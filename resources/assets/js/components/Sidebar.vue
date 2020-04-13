<template>
    <div class="col-md-3">
        <aside class="sidebar">
            <div class="category-list">
                <ul>
                    <router-link to="/dashboard">Online Class</router-link>
                    <router-link to="/course">Courses</router-link>
                    <router-link to="/lecture">Lecture Video/Notes</router-link>
                    <router-link to="/assignments">Assignments</router-link>
                    <router-link to="/quiz">Quizzes</router-link>
                    <router-link to="/users">Students</router-link>
                    <router-link to="/assignments">Messages</router-link>
                </ul>
            </div>
        </aside>
    </div>
</template>

<script>
    export default {
        name: 'app-header',
        

        methods:{
            
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
   
    .router-link-active{
        background-color: #0d47a1 !important;
        border-color: #0d47a1 !important;
        color: #fff !important;
    }
</style>