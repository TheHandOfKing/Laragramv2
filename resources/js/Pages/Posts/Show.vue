<template>
  <Head :title="pageTitle" />
  <AuthenticatedLayout>
    <section class="profile-info">
      <div class="mt-6 post-data">
        <div class="post-info d-flex">
          <div class="post-image w-2/3">
            <img :src="media[0].original_url" alt="" />
          </div>

          <div class="post-details w-1/3">
            <div class="poster p-4">
              <div class="user-detials flex items-center">
                <span class="image mr-4">
                  <img :src="user.profilePicture" alt="" />
                </span>

                <span
                  ><Link
                    style="font-size: 0.875rem"
                    :href="route('profile', user.slug)"
                    >{{ user.username }}</Link
                  ></span
                >
              </div>
            </div>

            <div class="comment-section flex flex-col">
              <post-comment-template
                v-for="(comment, index) in commentsData"
                :key="index"
                :comment="comment"
                :user="user"
                @comment-response="respondToComment"
              ></post-comment-template>
            </div>

            <div class="post-comment p-4">
              <div class="utility-section flex justify-between">
                <div class="like-share-comment flex items-center">
                  <span class="mr-3"
                    ><button class="_abl-" type="button">
                      <div class="_abm0 _abl_">
                        <span v-html="icons.like" class=""></span>
                      </div></button></span
                  ><span class="mr-3"
                    ><button class="_abl-" type="button">
                      <div
                        v-html="icons.comment"
                        class="_abm0 _abm1"
                      ></div></button></span
                  ><span class="mr-3"
                    ><button class="_abl-" type="button">
                      <div
                        v-html="icons.share"
                        class="_abm0 _abl_"
                      ></div></button
                  ></span>
                </div>

                <div class="save">
                  <div v-html="icons.save" class="_abm0 _abm1"></div>
                </div>
              </div>

              <div class="post-metadata">
                <div class="three-users-likes">
                  Liked by pavlovic_marko33 and 101 others
                </div>
                <small>{{ post.created_at }}</small>
              </div>

              <div class="post-a-comment flex">
                <input
                  v-model="comment.body"
                  type="text"
                  name=""
                  id=""
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
        </div>
      </div>
    </section>

    <div class="modals"></div>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import SettingsModal from "@/Components/SettingsModal.vue";
import PostCommentTemplate from "@/Components/Comments/PostCommentTemplate.vue";

export default {
  components: {
    AuthenticatedLayout,
    Head,
    Link,
    PostCommentTemplate,
    SettingsModal,
  },
  props: ["post", "user", "pageTitle", "media", "comments"],
  data() {
    return {
      icons: {
        like: `<svg
            aria-label="Like"
            class="x1lliihq x1n2onr6"
            color="#000"
            fill="#000"
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

      commentsData: this.comments,
      comment: {
        body: "",
        post_id: this.post.id,
      },
    };
  },
  computed: {},

  methods: {
    onCommentSubmit() {
      axios.post(this.route("comments.store", this.comment)).then((data) => {
        let comment = data.data.comment;

        this.commentsData.push(comment);
      });
    },

    respondToComment(data) {
      this.comment.parent_id = data.parent_id;
      this.comment.body = "@" + data.username;
    },
  },
};
</script>

<style lang="scss" scoped>
small {
  font-size: 10px;
}
.profile-info {
  margin-left: 190px;
  padding: 30px 20px 0;
  margin: 0 auto 30px;
  max-width: 1135px;

  .post-data {
    align-items: center;
    display: flex;
    flex-direction: column;
    margin: 0 auto;
    position: relative;
    width: 100%;

    .post-info {
      border: 1px solid #121212;
      border-bottom-right-radius: 3px;
      border-top-right-radius: 3px;
      width: 100%;
      display: flex;
      min-height: 800px;
      max-height: 800px;

      .post-image {
        display: flex;
        flex-direction: column;
        pointer-events: auto;
        position: relative;
        flex-grow: 1;
        justify-content: center;
        min-height: 550px;
        overflow: hidden;

        img {
          height: 100%;
          object-fit: cover;
        }
      }

      .post-details {
        min-height: 550px;

        .comment-section {
          overflow-y: scroll;
          height: calc(100% - 195px);
        }

        .comment-section::-webkit-scrollbar {
          width: 5px;
        }

        .comment-section::-webkit-scrollbar-track {
          background: #f1f1f1;
        }

        .comment-section::-webkit-scrollbar-thumb {
          background: #888;
          border-radius: 5px;
        }

        .comment-section::-webkit-scrollbar-thumb:hover {
          background: #555;
        }

        .post-comment {
          border-top: 1px solid #121212;

          .three-users-likes {
            font-size: 12px;
          }
        }

        .poster {
          border-bottom: 1px solid #121212;

          .image {
            height: 32px;
            width: 32px;
            img {
              border-radius: 50%;
            }
          }
        }
      }
    }
  }
}
</style>