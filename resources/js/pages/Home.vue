<template>
  <MusicLayout>
    <template #title>
      Hello world
    </template>

    <template #content>
      <div>
        <input v-model="firstname" type="text" name="firstname" id="firstname">
        <input v-model="lastname" type="text" name="lastname" id="lastname"><br>
        {{ fullName }}
      </div>
    </template>
  </MusicLayout>
</template>

<script lang="ts">
import MusicLayout from '@/layouts/MusicLayout.vue';

export default {
  name: 'Home',
  components: {
    MusicLayout,
  },
  data() {
    return {
      firstname: 'John',
      lastname: 'Doe',
    }
  },
  computed: {
    fullName() {
      return this.firstname + ' ' + this.lastname;
    }
  }
}
</script>
