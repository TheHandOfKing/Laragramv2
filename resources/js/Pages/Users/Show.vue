<template>
  <Head :title="pageTitle" />
  <AuthenticatedLayout>
    <section class="profile-info">
      <div class="profile-description">
        <div class="profile-picture">
          <img :src="user.profilePicture" alt="profile-pic" />
        </div>
        <div class="info">
          <div class="sections">
            <span>{{ user.username }}</span>
            <Link
              class="bg-white hover:bg-gray-200 text-black font-bold py-2 px-4 rounded"
              :href="route('profile.edit')"
              >Edit Profile</Link
            >
            <span @click="activateModal" class="cursor-pointer"
              ><svg
                aria-label="Options"
                class="x1lliihq x1n2onr6"
                color="#000"
                fill="#000"
                height="24"
                role="img"
                viewBox="0 0 24 24"
                width="24"
              >
                <title>Options</title>
                <circle
                  cx="12"
                  cy="12"
                  fill="none"
                  r="8.635"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                ></circle>
                <path
                  d="M14.232 3.656a1.269 1.269 0 0 1-.796-.66L12.93 2h-1.86l-.505.996a1.269 1.269 0 0 1-.796.66m-.001 16.688a1.269 1.269 0 0 1 .796.66l.505.996h1.862l.505-.996a1.269 1.269 0 0 1 .796-.66M3.656 9.768a1.269 1.269 0 0 1-.66.796L2 11.07v1.862l.996.505a1.269 1.269 0 0 1 .66.796m16.688-.001a1.269 1.269 0 0 1 .66-.796L22 12.93v-1.86l-.996-.505a1.269 1.269 0 0 1-.66-.796M7.678 4.522a1.269 1.269 0 0 1-1.03.096l-1.06-.348L4.27 5.587l.348 1.062a1.269 1.269 0 0 1-.096 1.03m11.8 11.799a1.269 1.269 0 0 1 1.03-.096l1.06.348 1.318-1.317-.348-1.062a1.269 1.269 0 0 1 .096-1.03m-14.956.001a1.269 1.269 0 0 1 .096 1.03l-.348 1.06 1.317 1.318 1.062-.348a1.269 1.269 0 0 1 1.03.096m11.799-11.8a1.269 1.269 0 0 1-.096-1.03l.348-1.06-1.317-1.318-1.062.348a1.269 1.269 0 0 1-1.03-.096"
                  fill="none"
                  stroke="currentColor"
                  stroke-linejoin="round"
                  stroke-width="2"
                ></path></svg
            ></span>
          </div>
          <div class="sections mt-6">
            <div class="posts">
              <span class="font-bold">{{ postsCount }}</span> Posts
            </div>
            <div class="posts">
              <span class="font-bold">472</span> followers
            </div>
            <div class="posts">
              <span class="font-bold">420</span> following
            </div>
          </div>
          <div class="sections mt-6 flex-col align-start-important">
            <div class="name">{{ user.name }}</div>
            <div class="description mt-3">{{ user.description }}</div>
          </div>
        </div>
      </div>
      <div class="sections stories-collections">
        <!-- Make a Component out of this -->
        <div class="story-container">
          <div class="story"></div>
        </div>

        <div class="add-story-button cursor-pointer">
          <div class="circle">
            <div
              class="flex items-center justify-center radius"
              style="width: 77px; height: 77px"
            >
              <svg
                aria-label="Plus icon"
                class="x1lliihq x1n2onr6"
                color="rgb(115, 115, 115)"
                fill="rgb(115, 115, 115)"
                height="44"
                role="img"
                viewBox="0 0 24 24"
                width="44"
              >
                <title>Plus icon</title>
                <path
                  d="M21 11.3h-8.2V3c0-.4-.3-.8-.8-.8s-.8.4-.8.8v8.2H3c-.4 0-.8.3-.8.8s.3.8.8.8h8.2V21c0 .4.3.8.8.8s.8-.3.8-.8v-8.2H21c.4 0 .8-.3.8-.8s-.4-.7-.8-.7z"
                ></path>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <div class="posts">
        <hr />
        <div class="buttons flex justify-center">
          <div class="posts">
            <div @click="toggleData('posts')" class="button clickable">
              <span class="svg"></span>
              <div class="title">Posts</div>
            </div>
          </div>
          <div class="reels clickable">
            <span class="svg"></span>
            <div class="title">Reels</div>
          </div>
          <div class="saved clickable">
            <span class="svg"></span>
            <div class="title">Saved</div>
          </div>
          <div class="tag clickable">
            <span class="svg"></span>
            <div class="title">Tagged</div>
          </div>
        </div>
      </div>
      <div
        v-if="posts.data.length > 0"
        class="mt-6 data-block flex flex-wrap justify-start"
      >
        <div
          v-for="(row, rowIndex) in postRows"
          :key="rowIndex"
          class="flex justify-start"
        >
          <div v-for="post in row" :key="post.id" class="post mr-6 mt-6">
            <Link :href="route('posts.show', post.slug)">
              <img :src="post.media[0].original_url" alt="" />
            </Link>
          </div>
        </div>
      </div>
      <div class="data-block flex justify-center" v-else>
        <span>You have not created any posts yet.</span>
      </div>
    </section>

    <div class="modals">
      <settings-modal
        v-if="isActive"
        @close-modal="closeModal"
      ></settings-modal>

      <create-post-modal
        style="width: 100%; height: 100%"
        v-if="createPostModalOpen"
        @close-modal="closeCreateModal"
      ></create-post-modal>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import SettingsModal from "@/Components/SettingsModal.vue";
import CreatePostModal from "@/Components/CreatePostModal.vue";

export default {
  components: {
    AuthenticatedLayout,
    Head,
    Link,
    SettingsModal,
    CreatePostModal,
  },
  props: ["user", "posts", "pageTitle", "postsCount"],
  data() {
    return {
      isActive: false,
      createModalActive: false,
    };
  },
  computed: {
    createPostModalOpen() {
      return this.$store.state.createPostModal.createPostModal;
    },
    postRows() {
      const posts = this.posts.data;
      const chunked = [];

      for (let i = 0; i < posts.length; i += 3) {
        chunked.push(posts.slice(i, i + 3));
      }

      return chunked;
    },
  },

  methods: {
    activateModal() {
      this.isActive = true;
    },

    closeModal() {
      this.isActive = false;
    },

    toggleData(model) {},

    closeCreateModal() {
      this.$store.dispatch("createPostModal/closeCreateModalAction");
    },
  },
};
</script>

<style lang="scss" scoped>
.clickable {
  margin-top: -1px;
  border-top: 1px solid black;
  cursor: pointer;
  display: flex !important;
  flex-direction: row;
  font-family: var(--font-family-system);
  height: 52px;
  justify-content: center;
  text-transform: uppercase;
  align-items: center;
  margin-right: 50px;
}

.profile-info {
  margin-left: 190px;
  padding: 30px 20px 0;
  margin: 0 auto 30px;
  max-width: 935px;

  .stories-collections {
    align-items: stretch;
    display: flex;
    width: 100%;

    .add-story-button {
      display: flex;
      align-items: center;
      justify-content: center;

      .circle {
        border: 1px solid #000;
        border-radius: 50%;

        .radius {
          border: 1px solid #000;
          border-radius: 50%;
          margin: 2px;
        }
      }
    }

    .story-container,
    .add-story-button {
      height: 128px;
      width: 125px;

      .story {
        cursor: pointer;
        height: 100%;
      }
    }
  }

  .profile-description {
    display: flex;
    justify-content: center;

    .info {
      display: flex;
      flex-direction: column;
      min-width: 313px;
      margin-left: 100px;

      .align-start-important {
        align-items: start !important;
      }

      .sections {
        display: flex;
        align-items: center;
        justify-content: space-between;
      }
    }

    .profile-picture {
      width: 150px;
      height: calc(148px + 2px);
      cursor: pointer;

      img {
        border-radius: 50%;
        height: 100%;
        object-fit: cover;
      }
    }
  }

  .post {
    height: 293px;
    width: 293px;
    cursor: pointer;

    img {
      object-fit: cover;
      height: 100%;
    }
  }
}
</style>