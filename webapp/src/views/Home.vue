<template>
  <div class="main">
    <Blog msg="Welcome to Your Vue.js App"/>
  </div>
</template>

<script>
// @ is an alias to /src
import Blog from '@/components/Blog.vue'

export default {
  name: 'blog',
  components: {
    Blog
  }
}
</script>

<style lang="scss">
  body {
    color: white;
  }
  .main {
    position: absolute;
    width: 100%;
    min-height: calc(100vh - 120px);
    background-color: rgba(255,255,255, .4)
  }

</style>
