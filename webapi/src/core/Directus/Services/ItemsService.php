<?php

namespace Directus\Services;

use Directus\Database\Exception\ItemNotFoundException;
use Directus\Database\RowGateway\BaseRowGateway;
use Directus\Database\Schema\SchemaManager;
use Directus\Exception\ForbiddenException;
use Directus\Permissions\Exception\ForbiddenCollectionReadException;
use Directus\Util\ArrayUtils;
use Directus\Util\StringUtils;
use Directus\Validator\Exception\InvalidRequestException;
use Zend\Db\TableGateway\TableGateway;

class ItemsService extends AbstractService
{
    const SINGLE_ITEM_PARAMS_BLACKLIST = [
        'filter',
        'q',
        'status'
    ];

    public function createItem($collection, $payload, $params = [])
    {
        $this->enforceCreatePermissions($collection, $payload, $params);
        $this->validatePayload($collection, null, $payload, $params);

        $tableGateway = $this->createTableGateway($collection);
        $newRecord = $tableGateway->createRecord($payload, $this->getCRUDParams($params));

        try {
            $item = $this->find(
                $collection,
                $newRecord->getId(),
                ArrayUtils::omit($params, static::SINGLE_ITEM_PARAMS_BLACKLIST)
            );
        } catch (\Exception $e) {
            $item = null;
        }

        return $item;
    }

    /**
     * Finds all items in a collection limited by a limit configuration
     *
     * @param $collection
     * @param array $params
     *
     * @return array
     */
    public function findAll($collection, array $params = [])
    {
        // TODO: Use repository instead of TableGateway
        return $this->getItemsAndSetResponseCacheTags(
            $this->createTableGateway($collection),
            $params
        );
    }

    /**
     * Gets a single item in the given collection and id
     *
     * @param string $collection
     * @param mixed $id
     * @param array $params
     *
     * @return array
     */
    public function find($collection, $id, array $params = [])
    {
        $statusValue = $this->getStatusValue($collection, $id);
        $tableGateway = $this->createTableGateway($collection);

        $this->getAcl()->enforceRead($collection, $statusValue);

        return $this->getItemsByIdsAndSetResponseCacheTags($tableGateway, $id, array_merge($params, [
            'status' => null
        ]));
    }

    /**
     * Gets a single item in the given collection and id
     *
     * @param string $collection
     * @param mixed $ids
     * @param array $params
     *
     * @return array
     *
     * @throws ItemNotFoundException
     * @throws ForbiddenCollectionReadException
     */
    public function findByIds($collection, $ids, array $params = [])
    {
        $params = ArrayUtils::omit($params, static::SINGLE_ITEM_PARAMS_BLACKLIST);

        $statusValue = $this->getStatusValue($collection, $ids);
        $tableGateway = $this->createTableGateway($collection);
        $ids = StringUtils::safeCvs($ids, false, false);

        try {
            $this->getAcl()->enforceRead($collection, $statusValue);
        } catch (ForbiddenCollectionReadException $e) {
            if (is_array($ids) && count($ids) > 1) {
                throw $e;
            } else {
                throw new ItemNotFoundException();
            }
        }

        return $this->getItemsByIdsAndSetResponseCacheTags($tableGateway, $ids, array_merge($params, [
            'status' => null
        ]));
    }

    /**
     * Gets a single item in the given collection that matches the conditions
     *
     * @param string $collection
     * @param array $params
     *
     * @return array
     */
    public function findOne($collection, array $params = [])
    {
        $tableGateway = $this->createTableGateway($collection);

        return $this->getItemsAndSetResponseCacheTags($tableGateway, array_merge($params, [
            'single' => true
        ]));
    }

    /**
     * Updates a single item in the given collection and id
     *
     * @param string $collection
     * @param mixed $id
     * @param array $payload
     * @param array $params
     *
     * @return array
     *
     * @throws ItemNotFoundException
     */
    public function update($collection, $id, $payload, array $params = [])
    {
        $this->enforceUpdatePermissions($collection, $payload, $params);
        $this->validatePayload($collection, array_keys($payload), $payload, $params);
        $this->checkItemExists($collection, $id);

        $tableGateway = $this->createTableGateway($collection);

        // Fetch the entry even if it's not "published"
        $params['status'] = '*';
        $newRecord = $tableGateway->updateRecord($id, $payload, $this->getCRUDParams($params));

        try {
            $item = $this->find(
                $collection,
                $newRecord->getId(),
                ArrayUtils::omit($params, static::SINGLE_ITEM_PARAMS_BLACKLIST)
            );
        } catch (\Exception $e) {
            $item = null;
        }

        return $item;
    }

    public function delete($collection, $id, array $params = [])
    {
        $this->enforcePermissions($collection, [], $params);

        // TODO: Better way to check if the item exists
        // $item = $this->find($collection, $id);

        $tableGateway = $this->createTableGateway($collection);
        $tableGateway->deleteRecord($id, $this->getCRUDParams($params));

        return true;
    }

    /**
     * @param $collection
     * @param array $items
     * @param array $params
     *
     * @return array
     *
     * @throws InvalidRequestException
     */
    public function batchCreate($collection, array $items, array $params = [])
    {
        if (!isset($items[0]) || !is_array($items[0])) {
            throw new InvalidRequestException('batch create expect an array of items');
        }

        foreach ($items as $data) {
            $this->enforceCreatePermissions($collection, $data, $params);
            $this->validatePayload($collection, null, $data, $params);
        }

        $allItems = [];
        foreach ($items as $data) {
            $item = $this->createItem($collection, $data, $params);
            if (!is_null($item)) {
                $allItems[] = $item['data'];
            }
        }

        if (!empty($allItems)) {
            $allItems = ['data' => $allItems];
        }

        return $allItems;
    }

    /**
     * @param $collection
     * @param array $items
     * @param array $params
     *
     * @return array
     *
     * @throws InvalidRequestException
     */
    public function batchUpdate($collection, array $items, array $params = [])
    {
        if (!isset($items[0]) || !is_array($items[0])) {
            throw new InvalidRequestException('batch update expect an array of items');
        }

        foreach ($items as $data) {
            $this->enforceCreatePermissions($collection, $data, $params);
            $this->validatePayload($collection, array_keys($data), $data, $params);
            $this->validatePayloadHasPrimaryKey($collection, $data);
        }

        $collectionObject = $this->getSchemaManager()->getCollection($collection);
        $allItems = [];
        foreach ($items as $data) {
            $id = $data[$collectionObject->getPrimaryKeyName()];
            $item = $this->update($collection, $id, $data, $params);

            if (!is_null($item)) {
                $allItems[] = $item['data'];
            }
        }

        if (!empty($allItems)) {
            $allItems = ['data' => $allItems];
        }

        return $allItems;
    }

    /**
     * @param $collection
     * @param array $ids
     * @param array $payload
     * @param array $params
     *
     * @return array
     */
    public function batchUpdateWithIds($collection, array $ids, array $payload, array $params = [])
    {
        $this->enforceUpdatePermissions($collection, $payload, $params);
        $this->validatePayload($collection, array_keys($payload), $payload, $params);

        $allItems = [];
        foreach ($ids as $id) {
            $item = $this->update($collection, $id, $payload, $params);
            if (!empty($item)) {
                $allItems[] = $item['data'];
            }
        }

        if (!empty($allItems)) {
            $allItems = ['data' => $allItems];
        }

        return $allItems;
    }

    /**
     * @param $collection
     * @param array $ids
     * @param array $params
     *
     * @throws ForbiddenException
     */
    public function batchDeleteWithIds($collection, array $ids, array $params = [])
    {
        // TODO: Implement this into a hook
        if ($collection === SchemaManager::COLLECTION_ROLES) {
            $groupService = new RolesService($this->container);

            foreach ($ids as $id) {
                $group = $groupService->find($id);

                if ($group && !$groupService->canDelete($id)) {
                    throw new ForbiddenException(
                        sprintf('You are not allowed to delete group [%s]', $group->name)
                    );
                }
            }
        }

        foreach ($ids as $id) {
            $this->delete($collection, $id, $params);
        }
    }

    protected function getItem(BaseRowGateway $row)
    {
        $collection = $row->getCollection();
        $item = null;
        $statusValue = $this->getStatusValue($collection, $row->getId());
        $tableGateway = $this->createTableGateway($collection);

        if ($this->getAcl()->canRead($collection, $statusValue)) {
            $params['id'] = $row->getId();
            $params['status'] = null;
            $item = $this->getItemsAndSetResponseCacheTags($tableGateway, $params);
        }

        return $item;
    }

    protected function getStatusValue($collection, $id)
    {
        $collectionObject = $this->getSchemaManager()->getCollection($collection);

        if (!$collectionObject->hasStatusField()) {
            return null;
        }

        $primaryFieldName = $collectionObject->getPrimaryKeyName();
        $tableGateway = new TableGateway($collection, $this->getConnection());
        $select = $tableGateway->getSql()->select();
        $select->columns([$collectionObject->getStatusField()->getName()]);
        $select->where([
            $primaryFieldName => $id
        ]);

        $row = $tableGateway->selectWith($select)->current();

        return $row[$collectionObject->getStatusField()->getName()];
    }
}
