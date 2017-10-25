import Multiselect from 'vue-multiselect'
import AlbumUpload from '../components/backend/AlbumUpload'
import ImageUpload from '../components/backend/ImageUpload'

var app = new Vue({
	el: '#app',
	data: {
      album: {
        artists: [],
      },
      artists: [],

      tabs: {
        tracksList: true,
        info: false,
        upload: false,
        edit: false
      }
    },

    methods: {
        addArtist(newArtist) {
          this.album.artists.push(newArtist)
          this.artists.push(newArtist)
        },
        toggleTabs(tab) {
          this.tabs.tracksList = (tab == "tracksList" ? true : false)
          this.tabs.info = (tab == "info" ? true : false)
          this.tabs.upload = (tab == "upload" ? true : false)
          this.tabs.edit = (tab == "edit" ? true : false)
        },
        onLoad(cover) {
            this.cover = cover.src

            this.persist(cover.file)
        },
        persist(cover) {
            let data = new FormData()

            data.append('albumId', albumId)
            data.append('cover', cover)

            axios.post(storeCoverUrl, data)
                .then(() => location.reload())
        }
	},
  mounted() {
  	if (typeof artists != 'undefined') {
  		_.filter(artists, (artist) => {
  			this.album.artists.push(artist.name)
  		})
  	}
  },
	computed: {
		isFormDirty() {
		  return Object.keys(this.fields).some(key => this.fields[key].dirty);
		},
		isFormInvalid() {
			return Object.keys(this.fields).some(key => this.fields[key].invalid);
		}
	},
	created() {
	  axios.get('/admin/music/artists').then(response => {
	    this.artists = _.keysIn(response.data)
	  })
	},
   components: {
      Multiselect, AlbumUpload, ImageUpload
   }
})