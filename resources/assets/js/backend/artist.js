var app = new Vue({
	el: '#app',
	data: {
      /*
      * Index View
      */
      all: true,
      add: false,
      /*
      * Edit View
      */
      view: true,
      edit: false,
      albums: false,
      singles: false,
      tracks: false,
      /*
      * Show View
      */
      upload: false,
    },

    methods: {
        toggleIndex() {
          this.all = !this.all
          this.add = !this.add
        },
        toggleView(tab) {
        	this.view = (tab == "view" ? true : false)
        	this.edit = (tab == "edit" ? true : false)
        	this.albums = (tab == "albums" ? true : false)
        	this.singles = (tab == "singles" ? true : false)
        	this.tracks = (tab == "tracks" ? true : false)
        }
	},
	computed: {
	    isFormDirty() {
	      return Object.keys(this.fields).some(key => this.fields[key].dirty);
	    },
	    isFormInvalid() {
    	return Object.keys(this.fields).some(key => this.fields[key].invalid);
    	}
	 }
})