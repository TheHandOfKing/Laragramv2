<template>
  <div v-if="page === 0" class="flex items-center justify-center w-full">
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

  <div v-if="page === 1" class="flex items-center justify-center w-full">
    test
  </div>
</template>

<script>
export default {
  props: ["page"],
  data() {
    return {
      fileLimit: 1,
    };
  },

  methods: {
    uploadImage() {
      let files = event.target.files;

      if (this.uploadedFiles.length >= this.fileLimit) {
        this.errors.limitError = true;
        return;
      }

      for (let i = 0; i < files.length; i++) {
        if (i == this.fileLimit) {
          this.errors.limitError = true;
          break;
        }
        const file = files[i];
        this.fileUploads.push(file);
        this.uploadedFiles.push(URL.createObjectURL(file));
      }

      this.serverUpdate();
    },
  },
};
</script>

<style>
</style>