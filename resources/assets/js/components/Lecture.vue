<template>
	<div>
		<section v-if="title!='home'" class="page-name background-bg" data-image-src="images/breadcrumb.jpg">
	        <div class="overlay">
	            <div class="section-padding">
	                <div class="container">
	                    <h2 class="section-title">
	                    	{{ title }}
	                    </h2>
	                </div>
	            </div>
	        </div>
	    </section>

	    <section class="courses">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="course-items">
                       		<span v-if="lectures">
                            	<div class="row">
	                                <div class="col-md-4" v-for="lecture in lectures.data" :key="lecture.id">
	                                    <div class="item">
	                                        <div class="item-thumb">

	                                        	<span v-if="lecture.video_link">
	                                        		<video-embed :src="lecture.video_link"></video-embed>
	                                        		
	                                        	</span>
	                                        	<img v-bind:src="lecture.image" alt="Item Thumbnail" v-else>
	                                        </div>

	                                        <div class="item-details">
	                                            <h3 class="item-title">
	                                            	Title: <b>{{lecture.topic_name}}</b><br>
	                                            	Course Code: <b> {{ lecture.course_code }} </b>
												</h3>	
												<span v-if="currentUser.type==1" class="float-right">
                                                	<a href="#" @click="editModal(lecture)">
								                    	<i class="fa fa-edit"></i>
								                  	</a>
								                  	|
								                  	<a href="#" @click="deleteLecture(lecture.id)">
								                    	<i class="fa fa-trash text-red"></i>
								                  	</a>
					                            </span>

	                                            <span class="instructor">
	                                            	<p style="text-align:justify; height:105px">
	                                            		{{ lecture.description }}
	                                            	</p>
	                                            </span>
	                                        </div>
	                                    </div>
	                                </div>
                            	</div>  
                            	<div class="">
						            <pagination :data="lectures" @pagination-change-page="getResults"></pagination>
						        </div>                          
					        </span>
				          	<span v-else>
                            	<b-alert variant="danger" show>
                            		<h2 style="padding:50px; color:blue"> No Online Class Schedule</h2>
                            	</b-alert>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
	    </section>

	    <div class="modal fade" id="addLecture" tabindex="-1" role="dialog" aria-labelledby="addLectureLabel" aria-hidden="true">
	      	<div class="modal-dialog modal-dialog-centered" role="document">
	        	<div class="modal-content">

	          		<div class="modal-header">
	            		<h5 class="modal-title" id="addLectureLabel" v-show="!editMode">Add New</h5>
	            		<h5 class="modal-title" id="addLectureLabel" v-show="editMode">Edit Lecture</h5>
	            		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	              			<span aria-hidden="true">&times;</span>
	            		</button>
	          		</div>

	          		<form @submit.prevent="editMode ? updateLecture() : createLecture()">
		            <div class="modal-body">
		              <div class="form-group">
		              	<label>Select Course</label>
		              	<select v-model="form.course_code" class="form-control" >
		              		<option v-for="course in courses" v-bind:value="course.course_code">
		              			{{ course.name }} ({{ course.course_code }})
					        </option>
		              	</select>
		                <has-error :form="form" field="topic_name"></has-error>
		              </div>

		              	<div class="form-group">
		              		<label>Topic Title</label>
		                	<input v-model="form.topic_name" type="text" name="topic_name" class="form-control" placeholder="Lecture Topic" :class="{ 'is-invalid': form.errors.has('topic_name') }">
		                	<has-error :form="form" field="topic_name"></has-error>
		              	</div>

		              	<div class="form-group">
		              		<label>Select Status</label>
		              		<select v-model="form.status" class="form-control" >
		              			<option value="Live Class">Live Class</option>
		              			<option value="Recorded Class">Recorded Class</option>
		              		</select>
		              	</div>

		              	<span v-if="form.status=='Live Class'">
			              	<div class='form-group'>
			              		<label>Start Date/Time</label>

			              		<b-form-datepicker v-model="form.start_date" local="en" class="form-control mb-2" :class="{ 'is-invalid': form.errors.has('start_date') }"></b-form-datepicker>
								<has-error :form="form" field="start_date"></has-error>
			              		
			              		<b-form-timepicker v-model="form.start_time" locale="en" class="form-control mb-2" :class="{ 'is-invalid': form.errors.has('start_time') }"></b-form-timepicker>
			              		<has-error :form="form" field="start_time"></has-error>

			                </div>

			                <div class='form-group'>
			              		<label>End Date/Time</label>

			              		<b-form-datepicker v-model="form.end_date" local="en" class="form-control mb-2" :class="{ 'is-invalid': form.errors.has('end_date') }"></b-form-datepicker>
								<has-error :form="form" field="end_date"></has-error>

			              		<b-form-timepicker v-model="form.end_time" locale="en" class="form-control mb-2" :class="{ 'is-invalid': form.errors.has('end_time') }"></b-form-timepicker>
			              		<has-error :form="form" field="end_time"></has-error> 

			                </div>

							<div class="form-group">
			              		<label>Lesson Link (Zoom link for live class)</label>
			                	<input v-model="form.link" type="text" name="link" class="form-control" placeholder="Lecture link" :class="{ 'is-invalid': form.errors.has('link') }">
			                	<has-error :form="form" field="link"></has-error>
			              	</div>
			            </span>

			            <span v-else>
			            	<div class="form-group">
			              		<label>Video Link (Link to youtube or vimeo)</label>
			                	<input v-model="form.video_link" type="text" name="video_link" class="form-control" placeholder="https://" :class="{ 'is-invalid': form.errors.has('video_link') }">
			                	<has-error :form="form" field="video_link"></has-error>
			              	</div>
			            </span>
		              	<div class="form-group">
		              		<label>Short Description</label>
		              		<textarea v-model="form.description" rows="3" class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
		                	<has-error :form="form" field="description"></has-error>
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
		        lectures: {},
		        courses: [],

		        form: new Form({
		          	id: '',
		          	headers: { 'content-type': 'multipart/form-data' },
			        course_code: '',
			        topic_name: '',
			        start_time: '',
			        start_date: '',
			        end_time: '',
			        end_date: '',
			        note: '',
			        status: 'Live Class',
			        link: '',
			        video_link: '',
			        description: '',
		        }),
	        }
	    },

	    mounted() {
	        this.title = this.$route.name;

	      	
	      	this.loadCourses();
	      	this.loadLectures();
	      	
	      	Fuse.$on('AfterCreate',() => {
	        	this.loadCourses();
	        	this.loadLectures();
	      	});
	    },

	    methods: {
	    	getResults(page=1){
	        	axios.get('api/topic/past?page=' + page)
	        	.then(response => {
	          		this.lectures = response.data;
	        	});
	      	},
	      
	      	editModal(lecture){
	        	this.editMode = true,
	        	this.form.reset();
	        	$('#addLecture').modal('show');
	        	this.form.fill(lecture);
	      	},

	      	newModal(){
		        this.editMode = false,
		        this.form.reset();
		        $('#addLecture').modal('show');
	      	},

	      	loadCourses(){
		        return axios.get('api/topic/course') 
			        .then(({data}) => {
			          this.courses = data;
					}
				).catch(() => {
		          	console.log('error');
		        }); 
	      	},

	      	loadLectures(){
		        return axios.get('api/topic/past') 
			        .then(({data}) => {
			          this.lectures = data;
					}
				).catch(() => {
		          	console.log('error');
		        }); 
	      	},

	      	createLecture(){
	        	this.$Progress.start();
	        	let note = this.form.note;
	        	this.form.post('api/topic', note)
	        		.then(()=>{
	          		Fuse.$emit('AfterCreate');
	          		$('#addLecture').modal('hide')

			        Swal.fire(
		              	'Created!',
		              	'Lecture has been updated.',
		              	'success'
			        )
			        this.$Progress.finish();
			        Fuse.$emit('AfterCreate');
	        	})

		        .catch(() => {
		          	this.$Progress.fail();
		        });       
	      	},

	      	updateLecture(){
	        	this.$Progress.start();

	        	this.form.put('api/topic/'+this.form.id)
		        .then(()=>{
		          	$('#addLecture').modal('hide')
		          
		          	Swal.fire(
		              	'Updated!',
		              	'Lecture has been updated.',
		              	'success'
			        )
			        this.$Progress.finish();
			        Fuse.$emit('AfterCreate');
		        })

		        .catch(() => {
		        	this.$Progress.fail();
		        });       
	      	},

	      	deleteLecture(id){
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
		            this.form.delete('api/topic/'+id)
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

<style>
	.item img{
		width:480px;
		height:210px;
	}
</style>
