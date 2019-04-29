import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './registerServiceWorker'
import DirectusSDK from '@directus/sdk-js'

const client = new DirectusSDK()

client.login({
  url: 'http://lavidadev.test:1738',
  project: '_',
  email: 'trey@lavidadev.com',
  password: 'gilbert3'
})

client.getItems('blog')
  .then(data => {
    console.log(data)
  })
  .catch(error => console.error(error));
Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
