<template>

  <Head title="Tracks" />

  <MusicLayout>
    <template #title>
      Playlist - {{ playlist.title }}
    </template>

    <template #action>
      <Link :href="route('playlists.index')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded w-full mb-">
      Liste des playlists
      </Link>
    </template>

    <template #content>
      <TrackList :tracks="playlist.tracks" />
    </template>
  </MusicLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3';
import MusicLayout from '@/layouts/MusicLayout.vue';
import TrackList from '@/components/TrackList.vue';

export default {
  name: 'Index',
  components: {
    Head,
    MusicLayout,
    Link,
    TrackList,
  },
  props: {
    playlist: Object,
  }
}
</script>
