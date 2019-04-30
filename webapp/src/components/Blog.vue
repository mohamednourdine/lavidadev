<template>
  <div class="wrapper">
    <div v-if="loading" class="bubbles-wrapper">
      <div class="bubbles" id="b1">&nbsp;</div>
      <div class="bubbles" id="b2">&nbsp;</div>
      <div class="bubbles" id="b3">&nbsp;</div>
      <div class="bubbles" id="b4">&nbsp;</div>
      <div class="bubbles" id="b5">&nbsp;</div>
    </div>
    <ul v-for="entry in info">
      <li> {{ entry.id }} </li>
      <li v-html="entry.blog_content">  </li>
      <li> {{ entry.blog_image }} </li>
      <li> {{ entry.blog_meta_description }} </li>
      <li> {{ entry.blog_tags }} </li>
      <li> {{ entry.created_by }} </li>
      <li> {{ entry.created_on }} </li>
      <li> {{ entry.modified_by }} </li>
      <li> {{ entry.modified_on }} </li>
      <li> {{ entry.sort }} </li>
      <li> {{ entry.status }} </li>
      <li> {{ entry.title }} </li>
    </ul>
  </div>
</template>

<script>
import DirectusSDK from '@directus/sdk-js'

export default {
  data () {
    return {
      info: null,
      loading: true,
      errored: false
    }
  },
  mounted () {
    console.log(process.env.VUE_APP_DIRECTUS_EMAIL)

    const client = new DirectusSDK()
    client.login({
      url: 'http://lavidadev.test:1738',
      project: '_',
      email: process.env.VUE_APP_DIRECTUS_EMAIL,
      password: process.env.VUE_APP_DIRECTUS_PASSWORD
    })
      .then(() => {
        client.getItems('blog')
          .then((response) => {
            console.log(this.loading)
            console.log(response.data)
            this.info = response.data
          })
          .catch(error => {
            console.log(error)
            this.errored = true
          })
          .finally(() => {
            this.loading = false
            console.log(this.loading)
          })
      })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.wrapper {
  position: relative;
  overflow: auto;
  max-height: calc(100vh - 125px);
  min-width: 100vw;
}
.bubbles-wrapper {
  background-color: white;
  width: 100vw;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: center;
  align-items: center;
}
.bubbles {
  position: relative;
  display: inline-block;
  width: 45px;
  height: 45px;
  border-radius: 100%;
  -webkit-animation-name: scale;
  animation-name: scale;
  -webkit-animation-duration: 1.7s;
  animation-duration: 1.7s;
  -webkit-animation-timing-function: cubic-bezier(.42, 0, .58, 1);
  animation-timing-function: cubic-bezier(.42, 0, .58, 1);
  -webkit-animation-iteration-count: infinite;
  animation-iteration-count: infinite;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}
#b1 {
  background-color: #8861A4;
}
#b2 {
  background-color: #2495C1;
  -webkit-animation-delay: 100ms;
  animation-delay: 100ms;
}
#b3 {
  background-color: #48BB6D;
  -webkit-animation-delay: 200ms;
  animation-delay: 200ms;
}
#b4 {
  background-color: #F1C500;
  -webkit-animation-delay: 300ms;
  animation-delay: 300ms;
}
#b5 {
  background-color: #F35957;
  -webkit-animation-delay: 400ms;
  animation-delay: 400ms;
}
@-webkit-keyframes scale {
  0% {-webkit-transform: translateY(-50%) scale(0.2);transform: translateY(-50%) scale(0.2);}
  50% {-webkit-transform: translateY(50%) scale(1.2);transform: translateY(50%) scale(1.2);}
  100% {-webkit-transform: translateY(-50%) scale(0.2);transform: translateY(-50%) scale(0.2);}
}
@keyframes scale {
  0% {-webkit-transform: translateY(-50%) scale(0.2);transform: translateY(-50%) scale(0.2);}
  50% {-webkit-transform: translateY(50%) scale(1.2);transform: translateY(50%) scale(1.2);}
  100% {-webkit-transform: translateY(-50%) scale(0.2);transform: translateY(-50%) scale(0.2);}
}
</style>
