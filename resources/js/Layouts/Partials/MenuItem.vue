<template>
  <div class="menu-item-wrap">
    <div v-if="type !== 'button'" class="menu-item-content p-3">
      <Link href="/?next=%2F" role="link" tabindex="0">
        <div class="flex flex-row justify-start">
          <span class="mr-6" v-html="svg"></span> <span>{{ name }}</span>
        </div>
      </Link>
    </div>

    <div v-else class="menu-item-content p-3">
      <button
        v-if="name === 'Create'"
        href="/?next=%2F"
        role="button"
        tabindex="0"
        @click="openCreateModal"
      >
        <div class="flex flex-row justify-start">
          <span class="mr-6" v-html="svg"></span> <span>{{ name }}</span>
        </div>
      </button>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
export default {
  components: { Link },
  props: ["svg", "name", "type"],

  data() {
    return {
      createModalActive: false,
    };
  },
  methods: {
    openCreateModal() {
      this.$store.dispatch("createPostModal/openCreateModalAction");
    },
  },
};
</script>

<style lang="scss" scoped>
</style>