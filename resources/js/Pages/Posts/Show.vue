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
              <post-comment-template :user="user"></post-comment-template>
              <post-comment-template :user="user"></post-comment-template>
              <post-comment-template :user="user"></post-comment-template>
              <post-comment-template :user="user"></post-comment-template>
              <post-comment-template :user="user"></post-comment-template>
              <post-comment-template :user="user"></post-comment-template>

              <post-comment-template :user="user"></post-comment-template>
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
  props: ["post", "user", "pageTitle", "media"],
  data() {
    return {};
  },
  computed: {},

  methods: {},
};
</script>

<style lang="scss" scoped>
.profile-info {
  margin-left: 190px;
  padding: 30px 20px 0;
  margin: 0 auto 30px;
  max-width: 935px;

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
      max-height: 700px;

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
          height: calc(100% - 65px);
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