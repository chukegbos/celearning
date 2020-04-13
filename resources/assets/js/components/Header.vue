<template>
    <header class="masthead" v-if="currentUser">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="top-contact">
                            <div class="trggericon"><i class="fas fa-at"></i></div>
                            <div class="close"><i class="far fa-times-circle"></i></div>
                            <div class="contacts">
                                <span>
                                    <i class="fas fa-phone"></i> 
                                    <a href="tel:61383766284">(+61) 38376 6284</a>
                                </span>
                                <span>
                                    <i class="fas fa-envelope"></i> 
                                    <a href="mailto:">support@courseware.com</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="menu-search-form dropdown float-right">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>Search</span> <i class="fas fa-search"></i>
                            </a>
                            <div class="dropdown-menu">
                                <form action="#" class="menu-search">
                                    <input type="text" class="form-control" placeholder="Search ..." name="s" title="Search here" required>
                                    <input type="submit" class="form-control"> 
                                </form>
                            </div>
                        </div>

                        <template v-if="!currentUser">
                            <div class="top-contact float-right">
                                <span>
                                    <i class="fas fa-phone"></i>
                                    <router-link to="/login">Login</router-link>
                                </span>
                              
                                <span>
                                    <i class="fas fa-envelope"></i> 
                                    <router-link to="/register">Register</router-link>
                                </span>
                               
                            </div>
                        </template>
                        <template v-else>
                            <div class="user-area dropdown float-right">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Welcome {{currentUser.firstname}} 
                                </a>

                                <div class="user-menu dropdown-menu">
                                    <router-link to="/dashboard" class="nav-link">
                                        <i class="fa fa-home"></i> Dashboard
                                    </router-link>

                                    <a class="nav-link" href="#"><i class="fa fa-user"></i> Profile <span class="count">13</span></a>

                                    <a class="nav-link" href="#"><i class="fa fa-cog"></i> Settings</a>

                                    <a href="#!" @click.prevent="logout" class="dropdown-item">
                                    <i class="fa fa-power-off"></i> Logout</a>
                                </div>
                            </div>
                        </template>

                    </div>
                </div>
            </div>
        </div><!-- /.header-top -->

        <div class="header-bottom">
            <div class="container">
                <b-navbar toggleable class="navbar navbar-expand-md m-0">

                    <router-link class="navbar-brand" to="/">
                        <img src="images/logo.png" alt="Logo">
                    </router-link>

                    <b-navbar-toggle target="main-menu">
                        <span class="navbar-toggler-icon"></span>
                    </b-navbar-toggle>

                    <b-collapse class="collapse navbar-collapse" id="main-menu" is-nav>
                    
                        <ul class="navbar-nav">
                            <li class="nav-item menu-item-has-children dropdown">
                                <router-link to="/dashboard" class="nav-item">
                                    <i class="fa fa-camera"></i> Online Class
                                </router-link>
                            </li>

                            <li class="nav-item menu-item-has-children dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-stream"></i> Stream</a>
                                <div class="dropdown-menu">
                                    <router-link to="#" class="dropdown-item">
                                        Announcements
                                    </router-link>
                                    <router-link to="#" class="dropdown-item">
                                        Student Discussion
                                    </router-link>
                                </div>
                            </li>

                            <li class="nav-item menu-item-has-children dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-book"></i> Classwork</a>
                                <div class="dropdown-menu">
                                    <router-link to="/course" class="dropdown-item">
                                        Courses
                                    </router-link>
                                    <router-link to="/lecture" class="dropdown-item">
                                        Lecture Videos
                                    </router-link>
                                    <router-link to="#" class="dropdown-item">
                                        Notes/Material
                                    </router-link>
                                    <router-link to="#" class="dropdown-item">
                                        Assignment
                                    </router-link>
                                    <router-link to="#" class="dropdown-item">
                                        Quiz Assignment
                                    </router-link>
                                </div>
                            </li>


                            <li class="nav-item menu-item-has-children dropdown">
                                <router-link to="#" class="nav-item">
                                <i class="fa fa-users"></i> Students
                                </router-link>
                            </li>
                        </ul>
                    </b-collapse>
                </b-navbar>

            </div>
        </div>
    </header>
</template>

<script>
    export default {
        name: 'app-header',
        

        methods:{
            logout(){
                this.$store.commit('logout');
                this.$router.push('/login');
            }
        },
        computed:{
            currentUser(){
                return this.$store.getters.currentUser
            }
        }
    }
</script>

<style>
    .nav-link{
        color:black
    }
    .masthead .navbar .navbar-brand {
        background: white !important;
    }

    .masthead .navbar .navbar-nav li a {
        background: white !important;
        color: #1c1717 !important;
    }
</style>