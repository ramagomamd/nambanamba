import Multiselect from 'vue-multiselect'
import SingleUpload from '../components/backend/SingleUpload'

var app = new Vue({
	el: '#app',
	data: {
      /*
      * Index View
      */
      all: true,
      add: false,
      /*
      * Create View
      */
      upload: false,

      // Form Attributes
      categories: [],
      allGenres: [],
      genres: [],
      category: '',
      genre: '',
    },

    methods: {
        addGenre(newGenre) {
          this.genres.push(newGenre)
        },

        addCategory(newCategory) {
          this.categories.push(newCategory)
          this.category = newCategory
        },
        toggleIndex() {
          this.all = !this.all
          this.add = !this.add
        },
        setUpload() {
        	this.upload = true

        }
	},
  mounted() {

    if (typeof page != 'undefined') {
        this.categories = _.keysIn(categories)
        this.allGenres = _.keysIn(genres)

        if (page == "edit") {
          this.edit = true
          _.filter(getSingleGenres, (genre) => {
            this.genres.push(genre.name)
            if (genre.pivot.is_main) {
              this.genre = genre.name
            }
          })
          this.category = singleCategory.name
        }
    }
  },
	computed: {
		checkUpload() {
			if (this.category && this.genres.length && this.genre) {
				return true
			} else {
				return false
			}
		},
	    isFormDirty() {
	      return Object.keys(this.fields).some(key => this.fields[key].dirty);
	    },
	    isFormInvalid() {
    	return Object.keys(this.fields).some(key => this.fields[key].invalid);
    	}
	 },
   components: {
      Multiselect, SingleUpload
   }
})