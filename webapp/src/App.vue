<template>
  <div id="app">
    <nav id="nav">
      <div class="navLogo">
        <span class="titleTop">
          lavida
        </span>
        <span class="titleBottom">
          dev.com
        </span>
      </div>
      <div class="navLinks">
        <router-link to="/">Home</router-link>
        <router-link to="/about">About</router-link>
        <router-link to="/blog">Blog</router-link>
      </div>
    </nav>
    <router-view/>
  </div>
</template>
<script>
export default {
  props: {
    msg: String,
    loading: Boolean
  }
}
</script>
<style lang="scss">
@import url('https://fonts.googleapis.com/css?family=Montserrat:500,500i|Oswald:400,700');
body {
  padding: 0;
  margin: 0;
  background: linear-gradient(-45deg, #ee4848, #d5930d, #d5c80d, #55d50d, #00eae2, #496dff, #e649ff, #ff4990, #ea397e, #ea39ad);
  background-size: 1600% 1600%;
  -webkit-animation: AnimationName 60s ease infinite;
  -moz-animation: AnimationName 60s ease infinite;
  animation: AnimationName 60s ease infinite;
  font-family: 'Montserrat', sans-serif;

}
@-webkit-keyframes AnimationName {
  0%{
    background: linear-gradient(-45) 0% 50%;
  }
  50%{background-position:100% 50%}
  100%{background: linear-gradient(-270) 0% 50%;}
}
@-moz-keyframes AnimationName {
  0%{background-position:0% 50%}
  50%{background-position:100% 50%}
  100%{background-position:0% 50%}
}
@keyframes AnimationName {
  0%{background-position:0% 50%}
  50%{background-position:100% 50%}
  100%{background-position:0% 50%}
}
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  height: 100vh;
  color: #FFF;
}
#nav {
  padding: 10px;
  display: flex;
  flex-direction: row;
  background-color: transparent;
  border-bottom: 10px;
  border-bottom: 5px solid white;
  max-height: 125px;
  a {
    text-decoration: none;
    margin-left: 10px;
    margin-right: 10px;
    font-family: 'Oswald', sans-serif;
    font-weight: 600;
    text-transform: uppercase;
    color: white;
    text-align: left;
    font-size: 45px;
    line-height: 45px;
    &.router-link-exact-active {
      color: #464544;
    }
    &:hover {
      color: #2e2d2d;
    }
  }
  .navLogo {
    margin-left: 10%;
    display: flex;
    flex-direction: column;
    flex-wrap: nowrap;
    width: 50%;
    justify-content: flex-start;
  }
  .titleTop {
    font-family: 'Montserrat', sans-serif;
    text-transform: uppercase;
    font-style: italic;
    color: white;
    text-align: left;
    font-size: 30px;
    line-height: 30px;
  }
  .titleBottom {
    margin-left: -3px;
    margin-top: -10px;
    font-family: 'Oswald', sans-serif;
    font-weight: 600;
    text-transform: uppercase;
    color: white;
    text-align: left;
    font-size: 75px;
    line-height: 75px;
  }
  .navLinks {
    width: 50%;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: center;
    align-content: center;
    align-items: center;
  }
}
</style>
