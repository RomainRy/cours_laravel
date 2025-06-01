<template>
  <div>
    <input v-model="filter" type="text" name="filter" id="filter" placeholder="Rechercher..."
      class="shadow border rounded py-2 px-3 text-gray-700 appearance-none leading-tight focus:outline-none focus:shadow-outline mb-2">

    <div class="grid grid-cols-4 gap-4">
      <Track v-for="track in filteredTracks" :key="track.uuid" :track="track" @play="playTrack" />
    </div>
  </div>
</template>

<script>
import Track from '@/components/Track.vue';

export default {
  name: 'TrackList',
  components: {
    Track,
  },
  props: {
    tracks: Array,
  },
  data() {
    return {
      audio: null,
      currentTrack: null,
      filter: '',
    }
  },
  computed: {
    filteredTracks() {
      return this.tracks.filter(track =>
        track.title.toLowerCase().includes(this.filter.toLowerCase())
        || track.artist.toLowerCase().includes(this.filter.toLowerCase())
      );
    }
  },
  methods: {
    playTrack(track) {
      if (! this.currentTrack) {
        this.audio = new Audio('storage/' + track.music);
        this.audio.play();
      } else if (this.currentTrack === track.uuid) {
        this.audio.paused ? this.audio.play() : this.audio.pause();
      } else {
        this.audio.pause();
        this.audio.src = 'storage/' + track.music;
        this.audio.play();
      }

      this.currentTrack = track.uuid;
    },
  },
}
</script>
