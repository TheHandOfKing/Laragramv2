<template>
  <div v-if="page === 0" class="flex items-center justify-center w-full">
    <div v-if="urlsFromUpload.length === 0" class="w-full">
      <label
        for="dropzone-file"
        class="flex flex-col items-center justify-center w-full h-96 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50"
      >
        <div class="flex flex-col items-center justify-center pt-5 pb-6">
          <svg
            aria-hidden="true"
            class="w-10 h-10 mb-3 text-gray-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
            ></path>
          </svg>
          <p class="mb-2 text-sm text-gray-500">
            <span class="font-semibold">Click to upload</span> or drag and drop
          </p>
          <p class="text-xs text-gray-500">
            SVG, PNG, JPG or GIF (MAX. 800x400px)
          </p>
        </div>
        <input
          @input="uploadImage"
          id="dropzone-file"
          type="file"
          class="hidden"
        />
      </label>
    </div>
    <div v-else-if="urlsFromUpload.length > 0" class="image-preview">
      <img :src="urlsFromUpload[0]" alt="preview-image" />
    </div>
  </div>
  <!-- Page 2  -->
  <div v-if="page === 1" class="flex items-center justify-center w-full">
    <div class="w-2/3">
      <img :src="urlsFromUpload[0]" alt="preview-image" />
    </div>
    <div
      class="w-1/3 flex h-full items-start p-4 pt-0 flex-col"
      style="min-height: 298px"
    >
      {{ post }}
      <input
        v-model="post.description"
        type="text"
        name=""
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-6"
        placeholder="Write your caption here"
        id=""
      />

      <input
        v-model="post.location"
        type="text"
        name=""
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-6"
        placeholder="Add Location"
        id=""
      />

      <div class="advanced-settings w-full">
        <span
          @click="showAdvancedSettings = !showAdvancedSettings"
          class="flex items-center justify-between cursor-pointer"
          >Advanced Settings
          <span style="display: inline-block; transform: rotate(180deg)"
            ><svg
              aria-label="Down chevron icon"
              class="x1lliihq x1n2onr6"
              color="#000"
              fill="#000"
              height="16"
              role="img"
              viewBox="0 0 24 24"
              width="16"
            >
              <title>Down chevron icon</title>
              <path
                d="M21 17.502a.997.997 0 0 1-.707-.293L12 8.913l-8.293 8.296a1 1 0 1 1-1.414-1.414l9-9.004a1.03 1.03 0 0 1 1.414 0l9 9.004A1 1 0 0 1 21 17.502Z"
              ></path></svg></span
        ></span>

        <div
          v-if="showAdvancedSettings"
          class="advanced-settings-content flex flex-col"
        >
          <div class="flex justify-between items-center">
            <span class="p-4">Hide like and view counts on this post</span>
            <div class="flex items-center">
              <input
                v-model="post.likes_view"
                id="checked-checkbox"
                type="checkbox"
                value=""
                class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500"
              />
            </div>
          </div>

          <div class="flex justify-between items-center">
            <span class="p-4">Turn off commenting</span>
            <div class="flex items-center">
              <input
                v-model="post.no_comments"
                id="checked-checkbox"
                type="checkbox"
                value=""
                class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["page", "post"],
  computed: {
    urlsFromUpload() {
      return this.$store.getters["savePostImageData/getPostImageUrl"];
    },
    objectsFromUpload() {
      return this.$store.getters["savePostImageData/getPostImage"];
    },
  },

  data() {
    return {
      fileLimit: 1,
      showAdvancedSettings: false,

      errors: {
        limitError: false,
      },
    };
  },

  methods: {
    uploadImage() {
      let files = event.target.files;

      if (this.urlsFromUpload.length >= this.fileLimit) {
        this.errors.limitError = true;
        return;
      }

      for (let i = 0; i < files.length; i++) {
        if (i == this.fileLimit) {
          this.errors.limitError = true;
          break;
        }
        const file = files[i];
        console.log(file);
        this.$store.dispatch("savePostImageData/savePostImageAction", file);
        this.$store.dispatch(
          "savePostImageData/savePostImageUrlAction",
          URL.createObjectURL(file)
        );
      }

      //Do something on the server
      // this.serverUpdate();
    },
  },
};
</script>

<style>
</style>