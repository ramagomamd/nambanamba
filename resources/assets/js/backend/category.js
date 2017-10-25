import Multiselect from 'vue-multiselect'

var app = new Vue({
	el: '#app',
  components: {
    Multiselect
  },
	data: {
      /*
      * Index View
      */
      all: true,
      add: false,
      /*
      * Edit View
      */
      tabs: {
        genres: true,
        details: false,
        edit: false,
        albums: false,
        singles: false
      }
    },

    methods: {
        toggleIndex() {
          this.all = !this.all
          this.add = !this.add
        },
        toggleTabs(tab) {
          this.tabs.genres = (tab == "genres" ? true : false)
          this.tabs.details = (tab == "details" ? true : false)
          this.tabs.edit = (tab == "edit" ? true : false)
          this.tabs.albums = (tab == "albums" ? true : false)
          this.tabs.singles = (tab == "singles" ? true : false)
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