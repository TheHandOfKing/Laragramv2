<template>
  <div class="single-comment-template p-4 flex w-full">
    <div class="user-detials w-full items-start flex">
      <span class="image mr-3 mt-3">
        <img :src="user.profilePicture" alt="" />
      </span>

      <div class="comment-content">
        <Link class="text-sm link" :href="route('profile', user.slug)">{{
          user.username
        }}</Link>

        <div style="display: inline; word-wrap: break-word">
          <span
            style="display: inline !important; margin: 0 !important"
            class="text-sm"
          >
            asdasdasdadakjdasasdasdasdasdasdadasd</span
          >
        </div>

        <div class="date text-xs">47w</div>
      </div>
    </div>
  </div>
</template>
<script>
import { Link } from "@inertiajs/vue3";
export default {
  props: ["comment", "user"],

  components: {
    Link,
  },
};
</script>

<style lang="scss" scoped>
.image {
  height: 32px;
  width: 32px;
  img {
    border-radius: 50%;
  }
}

.comment-content {
  align-items: stretch;
  border: 0;
  box-sizing: border-box;
  display: inline-block;
  flex-shrink: 1;
  font: inherit;
  font-size: 100%;
  margin: 0;
  min-width: 0;
  flex-direction: column;
  padding: 0;
  position: relative;
  vertical-align: baseline;
  word-wrap: break-word;
}

.link {
  align-items: center;
  display: inline-flex;
}
</style>