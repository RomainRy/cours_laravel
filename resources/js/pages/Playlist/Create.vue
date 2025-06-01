<template>

  <Head title="Playlists" />

  <MusicLayout>
    <template #title>
      Ajouter une playlist
    </template>

    <template #action>
      <Link :href="route('playlists.index')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded w-full mb-">
      Liste des playlists
      </Link>
    </template>

    <template #content>
      <PlaylistForm :tracks="tracks" />
    </template>
  </MusicLayout>
</template>

<script lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import MusicLayout from '@/layouts/MusicLayout.vue';
import PlaylistForm from '@/components/PlaylistForm.vue';

export default {
  name: 'Index',
  components: {
    Head,
    MusicLayout,
    Link,
    PlaylistForm,
  },
  props: {
    tracks: Array,
  }
}
</script>
