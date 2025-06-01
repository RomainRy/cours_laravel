<template>
  <div class="max-w-sm rounded shadow-lg">
    <div class="w-full">
      <img :src="`/storage/${track.image}`" />
    </div>
    <div class="px-6 py-4">
      <div class="font-bold text-xl mb-2">{{ track.title }}</div>
      <small class="text-gray-700 text-base">{{ track.artist }}</small>
    </div>
    <div class="w-full flex justify-content-between">
      <Link v-if="$page.props.auth.isAdmin"  :href="route('tracks.edit', { track: track })" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 me-2 rounded w-full mb-1 text-center">
        Modifier
      </Link>
      <Link v-if="$page.props.auth.isAdmin"  :href="route('tracks.destroy', { track: track })" method="delete" as="button" preserve-scroll class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full mb-1 text-center">
        Supprimer
      </Link>
    </div>
    <!-- <button @click="destroy" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded w-full mb-1">
      Supprimer
    </button> -->
    <button @click="play" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded w-full mb-1">
      Lire
    </button>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
  name: 'Track',
  components: {
    Link,
  },
  props: {
    track: Object,
  },
  emits: [
    'play',
  ],
  methods: {
    destroy() {
      this.$inertia.delete(route('tracks.destroy', { track: this.track }), {
        preserveScroll: true,
      });
    },
    play() {
      this.$emit('play', this.track);
    }
  }
}
</script>
