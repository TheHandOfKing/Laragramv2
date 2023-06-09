<template>
  <div class="flex justify-center post-wrap flex-col mt-6">
    <div class="top-profile-info">
      <Link
        :href="route('profile', post.user.slug)"
        class="profile-data flex items-center"
      >
        <img class="mr-2" :src="post.user.profilePicture" alt="profile-image" />
        <span>{{ post.user.username }}</span>
      </Link>
    </div>
    <Link :href="route('posts.show', post.slug)">
      <img class="post-image" :src="post.mainImage" alt="" />
    </Link>
    <div class="post-comment p-4">
      <div class="utility-section flex justify-between">
        <div class="like-share-comment flex items-center">
          <span class="mr-3"
            ><button @click="like('post', post.id)" class="_abl-" type="button">
              <div class="_abm0 _abl_">
                <span :class="liked" v-html="icons.like" class=""></span>
              </div></button></span
          ><span class="mr-3"
            ><button @click="focusComment" class="_abl-" type="button">
              <div
                v-html="icons.comment"
                class="_abm0 _abm1"
              ></div></button></span
          ><span class="mr-3"
            ><button class="_abl-" type="button">
              <div v-html="icons.share" class="_abm0 _abl_"></div></button
          ></span>
        </div>

        <div class="save">
          <div
            @click="savePost(post.id)"
            v-html="icons.save"
            :class="saved"
            class="_abm0 _abm1 cursor-pointer"
          ></div>
        </div>
      </div>

      <div class="post-metadata">
        <div class="three-users-likes" v-if="post.likes_count > 0">
          <span>Liked by </span>
          <span v-for="(user, index) in likesMessage.users" :key="index">
            <Link :href="route('profile', user.slug)">{{ user.username }}</Link
            ><span v-if="index < likesMessage.users.length - 1">, </span>
          </span>
          <span>{{ likesMessage.otherLikes }}</span>
        </div>
        <div v-else>{{ likesMessage }}</div>
        <small class="mr-2">Posted {{ displayDate(post.created_at) }}</small>
        <small>Comments: {{ commentData.commentCount }}</small>
      </div>

      <div class="post-a-comment flex">
        <input
          v-model="comment.body"
          type="text"
          name=""
          @keyup.enter="onCommentSubmit"
          :id="commentBodyId"
          class="block text-sm w-full font-medium text-gray-900 border-none outline-none"
          style="height: 22px"
          placeholder="Add a comment"
        />
        <input
          @click="onCommentSubmit"
          type="submit"
          class="cursor-pointer"
          value="Post"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import { toHuman } from "@/helpers/momentUtils.js";
export default {
  components: {
    Link,
  },
  props: ["post", "index"],

  created() {
    this.checkIsLiked("post", this.post.id);
  },

  computed: {
    liked() {
      return this.isLiked ? "liked" : "default";
    },

    saved() {
      return this.isSaved ? "saved" : "default";
    },

    commentBodyId() {
      return "comment-body-" + this.index;
    },

    likesMessage() {
      if (this.post.likes_count === 0) return `No one liked this yet!`;
      let users = this.post.usersFromLikes.map((user) => ({
        slug: user.slug,
        username: user.username,
      }));

      return {
        users,
        otherLikes: ` and ${this.post.totalLikes} others`,
      };
    },
  },

  data() {
    return {
      icons: {
        like: `<svg
            aria-label="Like"
            class="x1lliihq x1n2onr6"
            height="24"
            role="img"
            viewBox="0 0 24 24"
            width="24"
          >
            <title>Like</title>
            <path
              d="M16.792 3.904A4.989 4.989 0 0 1 21.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 2.5 9.122a4.989 4.989 0 0 1 4.708-5.218 4.21 4.21 0 0 1 3.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 0 1 3.679-1.938m0-2a6.04 6.04 0 0 0-4.797 2.127 6.052 6.052 0 0 0-4.787-2.127A6.985 6.985 0 0 0 .5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 0 0 3.518 3.018 2 2 0 0 0 2.174 0 45.263 45.263 0 0 0 3.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 0 0-6.708-7.218Z"
            ></path></svg
        >`,
        comment: `<svg
          aria-label="Comment"
          class="x1lliihq x1n2onr6"
          color="#000"
          fill="#000"
          height="24"
          role="img"
          viewBox="0 0 24 24"
          width="24"
        >
          <title>Comment</title>
          <path
            d="M20.656 17.008a9.993 9.993 0 1 0-3.59 3.615L22 22Z"
            fill="none"
            stroke="currentColor"
            stroke-linejoin="round"
            stroke-width="2"
          ></path>
        </svg>`,
        share: `<svg
            aria-label="Share Post"
            class="x1lliihq x1n2onr6"
            color="#000"
            fill="#000"
            height="24"
            role="img"
            viewBox="0 0 24 24"
            width="24"
          >
            <title>Share Post</title>
            <line
              fill="none"
              stroke="currentColor"
              stroke-linejoin="round"
              stroke-width="2"
              x1="22"
              x2="9.218"
              y1="3"
              y2="10.083"
            ></line>
            <polygon
              fill="none"
              points="11.698 20.334 22 3.001 2 3.001 9.218 10.084 11.698 20.334"
              stroke="currentColor"
              stroke-linejoin="round"
              stroke-width="2"
            ></polygon>
          </svg>`,
        save: `<svg
          aria-label="Save"
          class="x1lliihq x1n2onr6"
          color="rgb(168, 168, 168)"
          fill="rgb(168, 168, 168)"
          height="24"
          role="img"
          viewBox="0 0 24 24"
          width="24"
        >
          <title>Save</title>
          <polygon
            fill="none"
            points="20 21 12 13.44 4 21 4 3 20 3 20 21"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
          ></polygon>
        </svg>`,
      },
      postData: {
        likesCount: this.post.likes_count,
        usersFromLikes: this.post.usersFromLikes,
        totalLikes: this.post.totalLikes,
      },
      commentData: {
        commentCount: this.post.comments_count,
        subbmitting: false,
      },
      comment: {
        body: "",
        post_id: this.post.id,
      },
      isLiked: false,
      isSaved: false,
    };
  },

  methods: {
    displayDate(date) {
      return toHuman(date);
    },

    like(model, id) {
      if (this.isLiked) {
        axios
          .post(`/${model}/${id}/like?unlike=true`)
          .then((response) => {
            this.isLiked = response.data.liked;
          })
          .catch((error) => {
            console.error(error);
          });
      } else {
        axios
          .post(`/${model}/${id}/like`)
          .then((response) => {
            this.isLiked = true;
            console.log(response.data);
          })
          .catch((error) => {
            console.error(error);
          });
      }
    },

    focusComment() {
      let commentBody = document.getElementById("comment-body-" + this.index);
      commentBody.focus();
    },

    checkIsLiked(model, id) {
      axios
        .get(`/${model}/${id}/like`)
        .then((response) => {
          this.isLiked = response.data.liked;
        })
        .catch((err) => {
          console.error(err);
        });
    },

    onCommentSubmit() {
      if (!this.commentData.subbmitting) {
        this.commentData.subbmitting = true;
        axios
          .post(this.route("comments.store", this.comment))
          .then((data) => {
            // Do something i guess?
            this.commentData.commentCount += 1;
            this.comment.body = "";
            this.commentData.subbmitting = false;
          })
          .catch((err) => {
            this.commentData.subbmitting = false;
            console.error(err);
          });
      }
    },

    savePost(id) {
      if (this.isSaved) {
        axios
          .post(`/${model}/${id}/save?unsave=true`)
          .then((response) => {
            this.isSaved = response.data.saved;
          })
          .catch((error) => {
            console.error(error);
          });
      } else {
        axios
          .post(`/${model}/${id}/save`)
          .then((response) => {
            this.isSaved = true;
            console.log(response.data);
          })
          .catch((error) => {
            console.error(error);
          });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.default {
  color: black;
  fill: black;
}

.liked {
  color: red;
  fill: red;
}

.post-wrap {
  border-radius: 30px;
  border: 1px solid gray;
  max-width: 468px;

  .top-profile-info {
    height: 50px;
    border-bottom: 1px solid gray;
    padding: 10px;
  }

  .post-image {
    height: 585px;
    object-fit: cover;
  }

  .profile-data {
    width: 408px;

    img {
      width: 32px;
      object-fit: cover;
      height: 32px;
      border-radius: 50%;
    }
  }
}
</style>