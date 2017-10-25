<script>
  import Howler from 'howler'
  export default {
    components: {
      Howler
    },
    data() {
      return {
        index: 0,
        sound: {
          state() {
            return "unloaded"
          }
        },
        playing: false,
        repeat: false,
        title: '',
        timer: '',
        duration: '',
        playlist: {}
      }
    },
    methods: {
      /**
     * Play a song in the playlist.
     * @param  {Number} index Index of the song in the playlist (leave empty to play the first or current).
     */
      play(index) {
        index = typeof index === 'number' ? index : this.index
        let data = this.playlist[index]

        // If we already loaded this track, use the current one.
        // Otherwise, setup and load a new Howl.
        if (data.howl) {
          this.sound = data.howl;
        } else {
          let app = this
          this.sound = data.howl = new Howl({
            src: data.url,
            html5: true, // Force to HTML5 so that the audio can stream in (best for large files).
            onplay: function() {
              app.playing = true
              // Display the duration.
              app.duration = app.formatTime(Math.round(this.duration()))

              // Start upating the progress of the track.
              requestAnimationFrame(app.step.bind(app))
            },
            onload() {
            },
            onend() {
              app.playing = false
              if (app.repeat) {
                app.play(app.index)
              } else if (app.playlist.length == 1) {
                app.sound.stop(app.index)
              } else {
                app.skip('right')
              }
            },
            onpause() {
              app.playing = false
            },
            onstop() {
              app.playing = false
            }
          });
        }

        // Begin playing the sound.
        this.$refs.progress.style.width = '0%'
        this.sound.play()

        // Update the track display.
        this.title = (index + 1) + '. ' + data.full_title

        // Keep track of the index we are currently playing.
        this.index = index
      },

      /**
       * Pause the currently playing track.
       */
      pause() {
        // Get the Howl we want to manipulate.
        this.sound = this.playlist[this.index].howl

        // Puase the sound.
        this.sound.pause();
        this.playing = false
      },

      /**
       * Skip to the next or previous track.
       * @param  {String} direction 'next' or 'prev'.
       */
      skip(direction) {
        // Get the next track based on the direction of the track.
        let index = 0;
        if (direction === 'prev') {
          index = this.index - 1
          if (index < 0) {
            index = this.playlist.length - 1
          }
        } else {
          index = this.index + 1
          if (index >= this.playlist.length) {
            index = 0
          }
        }
        console.log(index)

        this.skipTo(index)
      },

      /**
       * Skip to a specific track based on its playlist index.
       * @param  {Number} index Index in the playlist.
       */
      skipTo(index) {
        // Stop the current track.
        if (this.playlist[this.index].howl && index !== this.index) {
          this.playlist[this.index].howl.stop()
          // Reset progress.
          this.$refs.progress.style.width = '0%'
        }

        // Play the new track.
        this.play(index)
      },

      /**
       * Set the volume and update the volume slider display.
       * @param  {Number} val Volume between 0 and 1.
       */
      volume(val) {
        // Update the global volume (affecting all Howls).
        Howler.volume(val)

        // Update the display on the slider.
        /*let barWidth = (val * 90) / 100
        barFull.style.width = (barWidth * 100) + '%'
        sliderBtn.style.left = (window.innerWidth * barWidth + window.innerWidth * 0.05 - 25) + 'px'*/
      },

      /**
       * Seek to a new position in the currently playing track.
       * @param  {Number} per Percentage through the song to skip.
       */
      seek(per) {
        // Get the Howl we want to manipulate.
        this.sound = this.playlist[this.index].howl

        // Convert the percent into a seek position.
        if (this.sound.playing()) {
          this.sound.seek(this.sound.duration() * per)
        }
      },

      /**
       * The step called within requestAnimationFrame to update the playback position.
       */
      step() {
        // Get the Howl we want to manipulate.
        this.sound = this.playlist[this.index].howl

        // Determine our current seek position.
        let seek = this.sound.seek() || 0
        this.timer = this.formatTime(Math.round(seek))
        this.$refs.progress.style.width = (((seek / this.sound.duration()) * 100) || 0) + '%'

        // If the sound is still playing, continue stepping.
        if (this.sound.playing()) {
          requestAnimationFrame(this.step.bind(this))
        }
      },

      /**
       * Toggle the volume display on/off.
       */
      /*toggleVolume() {
        let display = (volume.style.display === 'block') ? 'none' : 'block'

        setTimeout(function() {
          volume.style.display = display
        }, (display === 'block') ? 0 : 500)
        volume.className = (display === 'block') ? 'fadein' : 'fadeout'
      },*/

      /**
       * Format the time from seconds to M:SS.
       * @param  {Number} secs Seconds to format.
       * @return {String}      Formatted time.
       */
      formatTime(secs) {
        let minutes = Math.floor(secs / 60) || 0
        let seconds = (secs - minutes * 60) || 0

        return minutes + ':' + (seconds < 10 ? '0' : '') + seconds
      }
    },
    mounted() {
      this.playlist = _.mapKeys(playlist, (value, key) => {
        return value.index;
      });
      this.playlist.length = _.size(this.playlist)
    }
  }
</script>

<style scoped>
  .player
  {
    position: relative;
    background: #8eb4cb;
    border-radius: 0 0 11px 11px;
    overflow: hidden;
  }

  .track-info
  {
    position: relative;
    height: 100px;
    overflow: hidden;
    text-align: center;
    width: 100%;
    top: 0;
  }

  .track-title
  {
    display: block;
    font-size: 19px;
    font-weight: bold;
    color: #fffffb;
    padding: 30px 0 5px 0;
    text-transform: uppercase;
    background-color: #8eb4cb;
  }

  .player-controls
  {
    cursor: pointer;
    display: block;
    color: rgba(255,255,255,1);
    font-size: 31px;
    padding-top: 0px;
    padding-left: 35px;
  }

  .player-controls a
  {
    margin-right: 35px;
    margin-bottom: 15px;
    text-decoration: none;
  }

  .player-controls a.active
  {
    color: rgba(255,255,255,0.7);
  }

  .player-footer
  {
    height: 90px;
    box-shadow: inset 0 0 200px rgba(0,0,0,0.6);
    border-radius: 0 0 11px 11px;
  }

  .player-bar
  {
    position: relative;
    height: 7px;
    background: #ffffff;
  }

  .progress
  {
    position: absolute;
    content: '';
    width: 0%;
    display: inline-block;
    height: 3px;
    background: rgba(151,0,51,1);
    margin-top: 2px;
  }

  .time-controls
  {
    height: 100%;
    line-height: 80px;
    overflow: hidden;
  }

  .time-controls span
  {
    width: 33.33%;
    height: 100%;
    float: left;
    display: inline-block;
    text-align: center;
    font-size: 18px;
    color: #ffffff;
  }

  .prev-track, .next-track
  {
    box-shadow: inset -40px 0 70px -40px rgba(0,0,0,0.1);
  }

  .song-controls
  {
    height: 100%;
    line-height: 80px;
    overflow: hidden;
  }

  .song-controls a
  {
    cursor: pointer;
    width: 33.33%;
    height: 100%;
    float: left;
    display: inline-block;
    text-align: center;
    font-size: 18px;
    color: #ffffff;
  }

  .current-duration, .total-duration
  {
    box-shadow: inset -40px 0 70px -40px rgba(0,0,0,0.1);
  }

  .player-controls
  {
    box-shadow: inset 0px 0px 0px 5px #cbb956;
  }

  .song-controls .play, .pause
  {
    box-shadow: inset 0px 0px 0px 5px #8f0031;
  }

  .song-controls a .fa-play, .fa-pause
  {
    position: absolute;
    font-size: 27px;
    margin-top: 26px;
    margin-left: -11px;
  }
</style>