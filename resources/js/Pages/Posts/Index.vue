<template>
  <section class="profile-info flex flex-col justify-center items-center">
    <post
      :index="index"
      :post="post"
      v-for="(post, index) in posts"
      :key="index"
    ></post>
  </section>
</template>

<script>
import Post from "./Post.vue";
export default {
  components: { Post },
  props: ["posts"],
  data() {
    return {
      postsData: this.posts,
    };
  },
};
</script>

<style>
</style>