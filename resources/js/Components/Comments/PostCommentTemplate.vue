<template>
  <div class="single-comment-template p-4 flex w-full flex-col">
    <div class="user-detials w-full items-start flex justify-between">
      <div class="wrap flex">
        <span class="image mr-3 mt-3">
          <img :src="user.profilePicture" alt="" />
        </span>
        <div class="comment-content">
          <Link class="text-sm link" :href="route('profile', user.slug)">{{
            user.username
          }}</Link>

          <div style="display: inline; word-wrap: break-word">
            <span style="display: inline !important" class="text-sm ml-3">
              {{ comment.body }}</span
            >
          </div>
          <div class="flex items-center">
            <div class="date text-xs mr-3">47w</div>
            <div
              @click="submit(comment.id, user.username, user.id)"
              class="reply text-xs cursor-pointer"
            >
              Reply
            </div>
          </div>
        </div>
      </div>

      <div class="like flex items-center cursor-pointer" style="height: 44px">
        <span class=""
          ><svg
            aria-label="Unlike"
            class="x1lliihq x1n2onr6"
            color="rgb(255, 48, 64)"
            fill="rgb(255, 48, 64)"
            height="12"
            role="img"
            viewBox="0 0 48 48"
            width="12"
          >
            <title>Unlike</title>
            <path
              d="M34.6 3.1c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5s1.1-.2 1.6-.5c1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z"
            ></path></svg
        ></span>
      </div>
    </div>
    <div class="subcomments">
      <template v-if="comment.children">
        <post-comment-template
          v-for="(child, index) in comment.children"
          :key="index"
          :comment="child"
          :user="user"
        />
      </template>
    </div>
  </div>
</template>
<script>
import { Link } from "@inertiajs/vue3";
export default {
  name: "PostCommentTemplate",
  props: ["comment", "user"],
  components: {
    Link,
    PostCommentTemplate: () => import("./PostCommentTemplate.vue"),
  },

  methods: {
    submit(parent, username, user_id) {
      this.$emit("comment-response", {
        parent_id: parent,
        user_id: user_id,
        username: username,
      });
    },
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