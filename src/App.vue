<template>
  <div id="nav">
    <router-link :to="{name: 'Clients'}">Клиенты</router-link>
    <router-link :to="{name: 'Loans',  params: { filter_field: '', filter_id: '' } }">Кредиты</router-link>
  </div>
  <div class="main">
    <div class="container">
      <router-view :key="$route.fullPath"/>
    </div>
  </div>
</template>
<script>
</script>
<style lang="scss">


body {
  margin: 0;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

#nav {
  padding: 15px;
  background: #c8cccc;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
  text-decoration: none;
  &:not(:last-child) {
    margin-right: 8px;
   }
}

#nav a.router-link-exact-active {
  color: #42b983;
}

.main {

}
.container {
  width: 100%;
  max-width: 1220px;
  height: 100%;
  margin: 0 auto;
}
</style>
