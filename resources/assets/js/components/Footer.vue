<template>
    <footer class="site-footer mt-3" v-if="currentUser">
        <div class="footer-bottom black-bg">
            <div class="section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="copy-right float-left">
                                <span> Copyright © 2020 <a href="#" target="_blank" rel="nofollow">Courseware</a>, All rights reservs  </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <ul class="menu float-right">
                                <li class="menu-item"><a href="#"> Privacy</a></li>
                                <li class="menu-item"><a href="#"> Terms</a></li>
                                <li class="menu-item"><a href="#"> Sitemap</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        name: 'app-footer', 
        computed:{
            currentUser(){
                return this.$store.getters.currentUser
            }
        }     
    }
</script>