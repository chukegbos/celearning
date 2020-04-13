<template>
    <div class="main">
       	<Header/>
      	<router-view></router-view>
      	<vue-progress-bar></vue-progress-bar>
      	<Footer/>
    </div>
</template>

<script>
import Header from './Header.vue';
import Footer from './Footer.vue';
export default {
    name: 'main-App',
    components: { Header, Footer }
}
</script>
