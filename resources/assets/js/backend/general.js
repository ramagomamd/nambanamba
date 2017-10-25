import Multiselect from 'vue-multiselect'
import SingleUpload from '../components/backend/SingleUpload'

var app = new Vue({
	el: '#app',
  components: {
    Multiselect, SingleUpload
  },
	data: {
      albums: {
        main: true,
        list: true,
        create: false,
        zip: false,
        remote: false
      },
      singles: {
        main: false,
        list: true,
        upload: false,
        remote: false
      },
      crawl: false,

      album: {
          artists: [],
          title: '',
          description: ''
        },
      artists: [],
    },

    methods: {
        toggleMain(tab) {
          this.crawl = (tab == "crawl" ? true : false)
          this.albums.main = (tab == "albums" ? true : false)
          this.singles.main = (tab == "singles" ? true : false)
        },
        toggleAlbum(tab) {
          this.albums.list = (tab == "list" ? true : false)
          this.albums.create = (tab == "create" ? true : false)
          this.albums.zip = (tab == "zip" ? true : false)
          this.albums.remote = (tab == "remote" ? true : false)
        },
        toggleSingle(tab) {
          this.singles.list = (tab == "list" ? true : false)
          this.singles.upload = (tab == "upload" ? true : false)
          this.singles.remote = (tab == "remote" ? true : false)
        },
        addArtist(newArtist) {
          this.album.artists.push(newArtist)
          this.artists.push(newArtist)
        },
	},
  created() {
      axios.get('/admin/music/artists').then(response => {
        this.artists = _.keysIn(response.data)
      })
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