<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

let props = defineProps({
  mustVerifyEmail: Boolean,
  status: String,
  imageData: Object,
  images: Object,
});

let uploadedFiles = ref(props.images);
let fileUploads = ref(props.imageData);
let errors = ref({ limitError: false });
let fileLimit = ref(1);

const form = useForm({ id: "", files: "" });

const removeImage = (index) => {
  uploadedFiles.value.splice(index, 1);

  let file = fileUploads.value[index];
  fileUploads.value.splice(index, 1);
  if (typeof file == "object") {
    deleteImage(file);
  }
};

const serverUpdate = () => {
  let formData = new FormData();

  fileUploads.value.forEach((file) => {
    formData.append("files[]", file);
  });

  axios
    .post(
      `/media/update-media/user/${
        usePage().props.auth.user.id
      }/profile-picture`,
      formData,
      {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      }
    )
    .then((data) => {
      uploadedFiles = data.data.images;
      fileUploads = data.data.imageData;

      this.$toast.show("Image has been uploaded", {
        type: "success",
        duration: 2000,
        dismissible: true,
        pauseOnHover: true,
        useDefaultCss: true,
      });
    })
    .catch((error) => {
      this.$toast.show("Something went wrong!", {
        type: "error",
        duration: 2000,
        dismissible: true,
        pauseOnHover: true,
        useDefaultCss: true,
        // all of other options may go here
      });
    });
};

const uploadImage = () => {
  let files = event.target.files;

  if (uploadedFiles.length >= fileLimit) {
    errors.limitError = true;
    return;
  }

  for (let i = 0; i < files.length; i++) {
    if (i == fileLimit) {
      errors.limitError = true;
      break;
    }
    const file = files[i];
    fileUploads.value.push(file);
    uploadedFiles.value.push(URL.createObjectURL(file));
  }

  serverUpdate();
};

const deleteImage = (media) => {
  axios
    .delete(route("model.deleteMedia", { media: media }))
    .then((data) => {
      this.$toast.show("The image has been deleted!", {
        type: "success",
        duration: 2000,
        dismissible: true,
        pauseOnHover: true,
        useDefaultCss: true,
      });
    })
    .catch((err) => {
      this.$toast.show("Something went wrong!", {
        type: "error",
        duration: 2000,
        dismissible: true,
        pauseOnHover: true,
        useDefaultCss: true,
        // all of other options may go here
      });
      console.log(err);
    });
};
</script>

<template>
  <Head title="Profile" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
          <UpdateProfileInformationForm
            :must-verify-email="mustVerifyEmail"
            :status="status"
            class="max-w-xl"
          />
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
          <UpdatePasswordForm class="max-w-xl" />
        </div>

        <div class="p4 sm:p-8 bg-white shadow sm:rounded-lg">
          <div class="relative z-0 mb-6 w-full group">
            <label
              for="formFileMultiple"
              class="form-label inline-block mb-2 text-gray-700"
              >Multiple files input</label
            >
            <input
              @input="uploadImage"
              class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
              type="file"
              id="formFileMultiple"
              multiple
            />

            <div
              v-if="errors.limitError"
              class="p-6 max-w-full bg-red-700 rounded-lg border border-gray-200 shadow-md flex justify-between mt-5"
            >
              <p class="text-white">Maximum file uploads exceeded</p>
            </div>
            <div
              v-if="uploadedFiles.length > 0"
              class="p-6 max-w-full bg-white rounded-lg border border-gray-200 shadow-md flex justify-between mt-5"
            >
              <div
                v-for="(image, index) in uploadedFiles"
                :key="index"
                class="image-holder relative"
              >
                <svg
                  class="absolute cursor-pointer bg-white rounded-full p-1"
                  @click="removeImage(index)"
                  width="26"
                  height="26"
                  viewBox="0 0 26 26"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M25.3222 23.7897L23.7895 25.3223L12.9983 14.5311L2.20894 25.3205L0.67909 23.7906L11.4685 13.0013L0.678711 2.21151L2.21139 0.678833L13.0011 11.4686L23.7899 0.679792L25.3198 2.20964L14.531 12.9984L25.3222 23.7897Z"
                    fill="#FF5000"
                  />
                </svg>

                <img :src="image" class="max-w-sm" alt="" />
              </div>
            </div>

            <div
              v-else
              class="p-6 max-w-full bg-white rounded-lg border border-gray-200 shadow-md flex justify-center mt-5"
            >
              <p class="text-black">Upload Images to see them!</p>
            </div>
          </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
          <DeleteUserForm class="max-w-xl" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
