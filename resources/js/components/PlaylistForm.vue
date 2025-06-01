<template>
  <form @submit.prevent="send">
    <!-- Title -->
    <div class="mb-3">
      <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre</label>
      <input v-model="form.title" type="text" name="title" id="title"
        class="shadow border rounded py-2 px-3 text-gray-700 appearance-none leading-tight focus:outline-none focus:shadow-outline mb-2"
        :class="{ 'border-red-500': form.errors.title }">
      <div class="text-red-500 text-xs italic">{{ form.errors.title }}</div>
    </div>

    <label for="tracks" class="block text-gray-700 text-sm font-bold mb-2">Musiques</label>
    <div v-for="track in tracks" :key="track.uuid">
      <input v-model="form.tracks" type="checkbox" name="tracks" :value="track.uuid" :id="track.uuid">
      <label :for="track.uuid">{{ track.title }}</label>
    </div>

    <input type="submit" :value="playlist ? 'Modifier la playlist' : 'Créer la playlist'"
      class="text-white font-bold rounded py-2 px-4 bg-blue-500 hover:bg-blue-700">
  </form>
</template>

<script>
export default {
  name: 'PlaylistTrack',
  props: {
    playlist: Object,
    tracks: Array,
  },
  data() {
    return {
      form: this.$inertia.form({
        title: this.playlist?.title ?? '',
        tracks: this.playlist ? this.playlist.tracks.map(track => track.uuid) : [],
      })
    }
  },
  methods: {
    send() {
      if (this.playlist) {
        this.form.put(route('playlists.update', { playlist: this.playlist }));
      } else {
        this.form.post(route('playlists.store'));
      }
    }
  }
}
</script>
