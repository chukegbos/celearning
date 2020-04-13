<template>
	<div>
		<section v-if="title!='home'" class="page-name background-bg" data-image-src="images/breadcrumb.jpg">
	        <div class="overlay">
	            <div class="section-padding">
	                <div class="container">
	                    <h2 class="section-title">{{ title }}</h2>
	                </div>
	            </div>
	        </div>
	    </section>

	    <section class="courses">
	        <div class="section-padding">
	            <div class="container">
	                <div class="row">
	                	
	                	<Sidebar/>
	                    <div class="col-md-9">
	                        <div class="filters">
	                            <div class="row">
	                                <div class="col-lg-6">
	                                	<h2>All Courses</h2>
	                                </div>
	                                <div class="col-lg-6">
	                                    <button class="btn btn-success" @click=newModal>Create Course <i class="fa fa-plus fa-fw"></i></button>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="course-items">
	                            <div class="row">

	                                <div class="col-md-12">
	                                    <div class="item">
	                                    	<div class="table-responsive p-0">
									            <table class="table table-hover">
									              <tr>
									                <th>Course Code</th>
									                <th>Couese Name</th>
									                <th>Registerd Date</th>
									                <th>Modify</th>
									              </tr>

									              <tr v-for="course in courses.data" :key="course.id">
									                <td>{{ course.course_code }}</td>
									                <td>{{ course.name }}</td>
									                <td>{{ course.created_at | myDate }}</td>
									                <td>
									                  <a href="#" @click="editModal(course)">
									                    <i class="fa fa-eye"></i>
									                  </a>
									                  |
									                  <a href="#" @click="editModal(course)">
									                    <i class="fa fa-edit"></i>
									                  </a>
									                  |
									                  <a href="#" @click="deleteCourse(course.id)">
									                    <i class="fa fa-trash text-red"></i>
									                  </a>
									                </td>
									              </tr>                  
									            </table>
									        </div>
									        <div class="">
									            <pagination :data="courses" @pagination-change-page="getResults"></pagination>
									        </div>
	                                    </div>
	                                </div>

	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </section>

	    <div class="modal fade" id="addCourse" tabindex="-1" role="dialog" aria-labelledby="addCourseLabel" aria-hidden="true">
	      	<div class="modal-dialog modal-dialog-centered" role="document">
	        	<div class="modal-content">

	          		<div class="modal-header">
	            		<h5 class="modal-title" id="addCourseLabel" v-show="!editMode">Add Course</h5>
	            		<h5 class="modal-title" id="addCourseLabel" v-show="editMode">Edit Course</h5>
	            		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	              			<span aria-hidden="true">&times;</span>
	            		</button>
	          		</div>

	          		<form @submit.prevent="editMode ? updateCourse() : createCourse()">
		            	<div class="modal-body">
		              		<div class="form-group">
		                		<input v-model="form.name" type="text" name="name" class="form-control" placeholder="Course Name" :class="{ 'is-invalid': form.errors.has('name') }">
		                		<has-error :form="form" field="name"></has-error>
		              		</div>

		              		<div class="form-group">
		                		<input v-model="form.course_code" type="text" name="course_code" class="form-control" placeholder="Course Code" :class="{ 'is-invalid': form.errors.has('course_code') }">
		                		<has-error :form="form" field="course_code"></has-error>
		              		</div>
		              	</div>
			            <div class="modal-footer">
			              	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			              	<button v-show="editMode" type="submit" class="btn btn-success">Update</button>
			              	<button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
			            </div>
		          </form>
		        </div>
		      </div>
	    </div>
	</div>
</template>

<script>
	import Sidebar from './Sidebar.vue';

	export default {

    	components: { Sidebar },
	    computed:{
	        currentUser(){
	            return this.$store.getters.currentUser
	        }
	    },

	    data(){
	        return{
	            title: '',
	            editMode: false,
		        model: {},
		        courses: {},
		        form: new Form({
		          id: '',
		          name: '',
		          course_code: '',
		        })
	        }
	    },

	    mounted() {
	        this.title = this.$route.name;
	      	this.loadCourses();
	      	Fuse.$on('AfterCreate',() => {
	        	this.loadCourses();
	      	});
	    },

	    methods: {
	      	getResults(page=1){
	        	axios.get('api/course?page=' + page)
	        	.then(response => {
	          		this.courses = response.data;
	        	});
	      	},

	      	editModal(course){
	        	this.editMode = true,
	        	this.form.reset();
	        	$('#addCourse').modal('show');
	        	this.form.fill(course);
	      	},

	      	newModal(){
		        this.editMode = false,
		        this.form.reset();
		        $('#addCourse').modal('show');
	      	},

	      	loadCourses(){
		        return axios.get('api/course') 
			        .then(({data}) => {
			          this.courses = data;
					}
				).catch(() => {
		          	console.log('error');
		        }); 
	      	},

	      	createCourse(){
	        	this.$Progress.start();

	        	this.form.post('api/course')
	        		.then(()=>{
	          		Fuse.$emit('AfterCreate');
	          		$('#addCourse').modal('hide')
			        toast({
			            icon: 'success',
			            title: this.form.name + ' Created successfully',
			        })
			        this.$Progress.finish();
	        	})

		        .catch(() => {
		          	this.$Progress.fail();
		        });       
	      	},

	      	updateCourse(){
	        	this.$Progress.start();

	        	this.form.put('api/course/'+this.form.id)
		        .then(()=>{
		          	$('#addCourse').modal('hide')
		          
		          	Swal.fire(
		              	'Updated!',
		              	'Course has been updated.',
		              	'success'
			        )
			        this.$Progress.finish();
			        Fuse.$emit('AfterCreate');
		        })

		        .catch(() => {
		        	this.$Progress.fail();
		        });       
	      	},

	      	deleteCourse(id){
	        	Swal.fire({
	          title: 'Are you sure?',
	          text: "You won't be able to revert this!",
	          icon: 'warning',
	          showCancelButton: true,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Yes, delete it!'
	        	})
		        .then((result) => {
		          if (result.value) {
		            this.$Progress.start();
		            this.form.delete('api/course/'+id)
		            .then(()=>{
		              Swal.fire(
		                'Deleted!',
		                'ourse has been deleted.',
		                'success'
		              )
		              this.$Progress.finish();
		              Fuse.$emit('AfterCreate');
		            })

		            .catch(() => {
		              Swal("Failed!", "Ops, Something went wrong, try again.", "Warning")
		            });
		          }
		        })
	      	},

	    },
	}
</script>
 
