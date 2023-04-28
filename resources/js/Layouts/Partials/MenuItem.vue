<template>
  <div class="menu-item-wrap">
    <div class="menu-item-content p-3">
      <Link href="/?next=%2F" role="link" tabindex="0">
        <div class="flex flex-row justify-start">
          <span class="mr-6" v-html="svg"></span> <span>{{ name }}</span>
        </div>
      </Link>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
export default {
  components: { Link },
  props: ["svg", "name"],
};
</script>

<style>
</style>