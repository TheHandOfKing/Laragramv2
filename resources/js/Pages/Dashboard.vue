<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { defineProps } from "vue";
import Posts from "./Posts/Index.vue";

const props = defineProps({
  posts: Array,
});
</script>

<template>
  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="bg-white overflow-hidden shadow-sm sm:rounded-lg posts-holder"
        >
          <posts :posts="posts"></posts>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
.posts-holder {
  height: 100vh;
  overflow-y: scroll;

  &::-webkit-scrollbar {
    width: 4px;
  }

  &::-webkit-scrollbar-track {
    background: #fff;
  }

  &::-webkit-scrollbar-thumb {
    background: #ff00bf;
    border-radius: 6px;
  }

  &::-webkit-scrollbar-thumb:hover {
    background: #ff00bf;
  }
}
</style>