<template>

<div class="panel panel-default">
    <div class="panel-heading"><strong>Upload Zip</strong> <small> </small></div>
    <div class="panel-body">
		<vue-clip :options="options" :on-added-file="fileAdded" :on-sending="sending" :on-queue-complete="queueComplete">
		  <template slot="clip-uploader-action">
		      <div>
		          <!-- Drop Zone -->
		          <div class="dz-message">
		            <div class="upload-drop-zone" id="drop-zone"> Drag and drop Zip files here </div>
		          </div>
		      </div>
		  </template>
		  <br />
		</vue-clip>

		<div class="list-group">
		<h4 class="list-group-item active" v-if="files.length">Upload Status</h4> <br>
			<div v-for="file in files">
				<!-- Upload Processing -->
				<div class="js-upload-finished" :id="file.name">
					<li class="list-group-item">
						<h4 class="list-group-item-heading">
				            <div v-if="file.status == 'success'" class="box-tools pull-right">
				                <p class="text-success">
				                	<span class="fa fa-check-square-o"> Successfully Uploaded!</span>
				                </p>   
				            </div>
				            <div v-else-if="file.status == 'error'" class="box-tools pull-right">
				                <p class="text-danger">
				                	<span class="fa fa-exclamation-triangle"> Something went wrong!</span>
				                </p> 
				            </div>
				            <div v-else-if="file.status == 'added' && file.progress" class="box-tools pull-right">
				                <p class="text-warning">
					                <span class="fa fa-hourglass-half"> Processing...</span>
				                </p>
				            </div>
				            <div v-else class="box-tools pull-right">
				                <p class="text-info">
					                <span class="fa fa-hourglass-o"> Waiting...</span>
				                </p>
				            </div>
							<strong>File Name:&nbsp;</strong> {{ file.name }}
						</h4>
					</li>
					<li class="list-group-item">
						<p class="list-group-item-text">
							<div class="progress" v-if="file.status == 'added' ">
								<div class="progress-bar progress-bar-striped" :class="progressClassObject(file.progress)" 
									role="progressbar" :aria-valuenow="file.progress" aria-valuemin="0" 
									aria-valuemax="100" :style="{width: file.progress + '%'}"> 
									<span class="sr-only">{{ file.progress + '% Complete' }}</span> 
								</div>
							</div>
							<div v-else-if="file.xhrResponse.statusCode == 201" class="alert alert-success">
								<p><strong>{{ file.xhrResponse.responseText }}</strong></p>
							</div>
							<div v-else-if="file.xhrResponse.statusCode == 508" class="alert alert-danger">
								<p class="strong">{{ file.xhrResponse.responseText }}</p>
							</div>
							<div v-else-if="file.xhrResponse.statusCode == 500 || file.status == 'error'" 
								class="alert alert-danger">
								<p class="strong">Something wrong happened!</p>
							</div>
							<div v-else class="alert alert-warning">
								<p class="strong">File Uploaded, some undetected error might have occured</p>
							</div>
						</p>
						<h4 class="list-group-item-heading">
							<strong>Progress:&nbsp;</strong> {{ parseInt(file.progress) + " % Complete" }}
						</h4>
						<h4 class="list-group-item-heading">
							<strong>Size:&nbsp;</strong> {{ file.size + " MB" }}
						</h4>
						<h4 class="list-group-item-heading">
							<strong>Status:&nbsp;</strong> 
							<span class="label" :class="statusClassObject(file.status)">{{ file.status }}</span>
						</h4>
					</li>
				</div> <br>
			</div>
			<div v-if="reload" @click="reloadPage" class="btn btn-success btn-lg"><strong>Done</strong></div>
		</div>
    </div>
  </div>
    
</template>

<script>
    import VueClip from 'vue-clip'

    Vue.use(VueClip)

    export default {
    	name: 'single-upload',
    	props: {
			genre: {
				type: String,
				required: true
			},
			category: {
				type: String,
				required: true
			}
		},
    	data() {
    		return {
    			options: {
			        url: storeSingleUrl,
			        parallelUploads: 2,
			        maxFilesize: 45,
			        acceptedFiles: 'audio/*',
			        headers: {
			            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			        }
			      },
			      files: [],
			      reload: false
    		}
    	},
        methods: {
        	fileAdded: function(file) {
        		file.name = _.upperFirst(_.toLower(file.name))
        		file.size = (file.size / 1000000).toFixed(2)
        		this.files.push(file)
        	},
        	progressClassObject: function (progress) {
			    return {
			      'progress-bar-danger': progress <= 25,
			      'progress-bar-warning': progress <= 50,
			      'progress-bar-info': progress <= 80,
			      'progress-bar-success': progress > 80
				}
			},
			statusClassObject: function(status)  {
				return {
					'label-success': status == 'success',
					'label-danger': status == 'error',
					'label-info': status  == 'added'
				}
			},
        	sending (file, xhr, formData) {
	          formData.append('category', this.category)
	          formData.append('genre', this.genre)
	          let input = document.getElementById(file.name)
	          // input.scrollTop += 60
	          input.scrollIntoView({ behavior: 'smooth' })
	        },

	        queueComplete() {
	        	this.reload = true
	        },
	        reloadPage() {
	        	if (this.reload)
	        		location.reload();
	        }
        }
    }
</script>

<style scoped>
	/*table layout - last column*/
	table tr td:last-child {
	    white-space: nowrap;
	    width: 1px;
	    text-align:right;
	}

	/* layout.css Style */
	.upload-drop-zone {
	  height: 200px;
	  border-width: 2px;
	  margin-bottom: 20px;
	}

	/* skin.css Style*/
	.upload-drop-zone {
	  color: #ccc;
	  border-style: dashed;
	  border-color: #ccc;
	  line-height: 200px;
	  text-align: center
	}
	.upload-drop-zone.drop {
	  color: #222;
	  border-color: #222;
	}



	.image-preview-input {
	    position: relative;
	    overflow: hidden;
	  margin: 0px;    
	    color: #333;
	    background-color: #fff;
	    border-color: #ccc;    
	}
	.image-preview-input input[type=file] {
	  position: absolute;
	  top: 0;
	  right: 0;
	  margin: 0;
	  padding: 0;
	  font-size: 20px;
	  cursor: pointer;
	  opacity: 0;
	  filter: alpha(opacity=0);
	}
	.image-preview-input-title {
	    margin-left:2px;
	}
</style>
