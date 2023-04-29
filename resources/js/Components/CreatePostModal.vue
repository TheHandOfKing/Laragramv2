<template>
  <div
    id="crypto-modal"
    tabindex="-1"
    aria-hidden="true"
    class="bg-opacity-70 bg-white fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center"
  >
    <div class="relative w-full max-w-4xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow">
        <div class="flex justify-between px-6 py-4 border-b rounded-t">
          <h3
            v-if="page == 0"
            class="text-base font-semibold text-gray-900 lg:text-xl"
          >
            Create New Post
          </h3>
          <div class="buttons">
            <button
              v-if="page > 0"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center"
              @click="page -= 1"
            >
              Back
            </button>
            <button
              v-if="tempImage"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center"
              @click="page += 1"
            >
              Next
            </button>
          </div>
          <button
            @click="close"
            type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex items-center"
            data-modal-hide="crypto-modal"
          >
            <svg
              aria-hidden="true"
              class="w-5 h-5"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-6">
          <ul class="my-4 space-y-3">
            <li>
              <form @submit.prevent="onSubmit">
                <create-post-component
                  @image-uploaded="saveImageData"
                  :page="page"
                ></create-post-component>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CreatePostComponent from "./Posts/CreatePostComponent.vue";

export default {
  components: { CreatePostComponent },
  data() {
    return {
      tempImage: "",
      page: 0,
      imageForm: this.$inertia.form({
        _method: "PUT",
        id: "",
        files: "",
      }),

      postForm: this.$inertia.form({
        _method: "PUT",
        id: "",
        description: "",
        location: "",
        user_id: "",
      }),
    };
  },
  methods: {
    close() {
      // your code to close the modal
      this.$emit("close-modal");
    },

    saveImageData(file) {
      this.$store.dispatch("savePostImageData/savePostImageAction", file);
    },

    onSubmit() {
      console.log("submitted");
    },
  },
};
</script>

<style>
</style>