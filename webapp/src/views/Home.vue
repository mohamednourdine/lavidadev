<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png">
    <HelloWorld msg="Welcome to Your Vue.js App"/>
  </div>
</template>

<script>
// @ is an alias to /src
import HelloWorld from '@/components/HelloWorld.vue'
import DirectusSDK from '@directus/sdk-js'

console.log(process.env.VUE_APP_DIRECTUS_EMAIL)

const client = new DirectusSDK()

client.login({
  url: 'http://lavidadev.test:1738',
  project: '_',
  email: process.env.VUE_APP_DIRECTUS_EMAIL,
  password: process.env.VUE_APP_DIRECTUS_PASSWORD
})

client.getItems('blog')
  .then(data => {
    console.log(data)
  })
  .catch(error => console.error(error))
export default {
  name: 'home',
  components: {
    HelloWorld
  }
}
</script>
