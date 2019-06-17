<template>
  <article class="wrapper">
    <div class="wrapper-inner">
      <div v-if="loading" class="bubbles-wrapper">
        <div class="bubbles" id="b1">&nbsp;</div>
        <div class="bubbles" id="b2">&nbsp;</div>
        <div class="bubbles" id="b3">&nbsp;</div>
        <div class="bubbles" id="b4">&nbsp;</div>
        <div class="bubbles" id="b5">&nbsp;</div>
      </div>
      <section>
        <div
          class="BlogContainer"
          v-for="entry in info"
          v-bind:key="entry.id"
          :style="{ 'background-image': 'url(/uploads/_/originals/'+ entry.blog_image +')' }
        ">
          <div class="Blog__ID"> {{ entry.id }} </div>
          <div class="Blog__Content" v-html="entry.blog_content">  </div>
          <div class="Blog__Image"> THIS THE IMAGE: {{ entry.blog_image }} </div>
          <div class="Blog__Description"> {{ entry.blog_meta_description }} </div>
          <div class="Blog__Tags"> {{ entry.blog_tags }} </div>
          <div class="Blog__CreatedBy"> {{ entry.created_by }} </div>
          <div class="Blog__CreatedOn"> {{ entry.created_on }} </div>
          <div class="Blog__ModifiedBy"> {{ entry.modified_by }} </div>
          <div class="Blog__ModifiedOn"> {{ entry.modified_on }} </div>
          <div class="Blog__Sort"> {{ entry.sort }} </div>
          <div class="Blog__Status"> {{ entry.status }} </div>
          <div class="Blog__Title"> {{ entry.title }} </div>
        </div>
      </section>
    </div>
  </article>
</template>

<script>
export default {
  data () {
    return {
      info: null,
      loading: true,
      errored: false,
      image: {}
    }
  },
  mounted () {
    console.log(process.env.VUE_APP_DIRECTUS_EMAIL)
    const blog = new axios();

    blog.get('/_/items/blog', {
      params: {
        limit: 5,
      }
    }).then(response => {
      console.log(response.data);
    })
    .finally(() =>{
       this.loading = false
    });
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
  .BlogContainer {
    width: 100%;
    height: calc(100vh - 120px);
    background-size: cover;
  }
  .Blog__ID {
    border: 1px solid black;
  }
  .Blog__Content {
    border: 1px solid black;
  }
  .Blog__Image {
    border: 1px solid black;
  }
  .Blog__Description {
    border: 1px solid black;
  }
  .Blog__Tags {
    border: 1px solid black;
     }
  .Blog__CreatedB {
    border: 1px solid black;
  }
  .Blog__CreatedO {
    border: 1px solid black;
  }
  .Blog__ModifiedBy {
    border: 1px solid black;
  }
  .Blog__ModifiedOn {
    border: 1px solid black;
  }
  .Blog__Sort {
    border: 1px solid black;
  }
  .Blog__Status {
    border: 1px solid black;
  }
  .Blog__Title {
    border: 1px solid black;
  }
  .wrapper {
    max-height: calc(100vh - 120px);
    overflow: auto;
    width: 100vw;
  }
  .wrapper-inner {
    padding: 10px;
    margin-left: 10%;
    margin-right: 10%;
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
