import Multiselect from 'vue-multiselect'

var app = new Vue({
	el: '#app',
	data: {
    track: {
          artists: [],
          features: [],
          producer: ''
        },
        artists: [],
      /*
      * Show View
      */
      view: true,
      edit: false
    },
    methods: {
        addArtist(newArtist) {
          this.track.artists.push(newArtist)
          this.artists.push(newArtist)
        },
        addFeature(newFeature) {
          this.track.features.push(newFeature)
          this.artists.push(newFeature)
        },
        addProducer(newProducer) {
          this.track.producer = newProducer
          this.artists.push(newProducer)
        },
        toggleView() {
          this.view = !this.view
          this.edit = !this.edit
        },
    },
  created() {
  	axios.get('/admin/music/artists').then(response => {
      this.artists = _.keysIn(response.data)
    })
  },
	mounted() {
      _.filter(getTrackArtists, (artist) => {
        this.track.artists.push(artist.name)
      })
      _.filter(getTrackFeatures, (feature) => {
        this.track.features.push(feature.name)
      })
      this.track.producer = getTrackProducer
	},
	computed: {
	    isFormDirty() {
	      return Object.keys(this.fields).some(key => this.fields[key].dirty);
	    },
	    isFormInvalid() {
		return Object.keys(this.fields).some(key => this.fields[key].invalid);
		}
	},
	components: {
	  Multiselect
	}
})