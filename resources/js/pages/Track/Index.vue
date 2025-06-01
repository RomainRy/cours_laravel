<template>

  <Head title="Tracks" />

  <MusicLayout>
    <template #title>
      Tracks
    </template>

    <template #action>
      <Link v-if="$page.props.auth.isAdmin" :href="route('tracks.create')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded w-full mb-">
      Ajouter une musique
      </Link>
    </template>

    <template #content>
      <TrackList :tracks="tracks" />
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
    tracks: Array,
  },
}
</script>
