<template>
  <div
    id="crypto-modal"
    tabindex="-1"
    aria-hidden="true"
    class="bg-opacity-70 bg-white fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center"
  >
    <div class="relative w-full max-w-md max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <button
          @click="close"
          type="button"
          class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
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
        <!-- Modal header -->
        <div class="px-6 py-4 border-b rounded-t dark:border-gray-600">
          <h3
            class="text-base font-semibold text-gray-900 lg:text-xl dark:text-white"
          >
            Profile Settings
          </h3>
        </div>
        <!-- Modal body -->
        <div class="p-6">
          <ul class="my-4 space-y-3">
            <li v-for="(item, index) in items" :key="index">
              <a
                :href="item.route"
                class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white"
              >
                <span class="flex-1 ml-3 whitespace-nowrap">{{
                  item.name
                }}</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      items: [
        {
          name: "QR Code",
          route: `${route("dashboard")}`,
        },
        {
          name: "Apps and Websites",
          route: `${route("dashboard")}`,
        },
        {
          name: "Notifications",
          route: `${route("dashboard")}`,
        },
        {
          name: "Privacy and Security",
          route: `${route("dashboard")}`,
        },
        {
          name: "Supervision",
          route: `${route("dashboard")}`,
        },
        {
          name: "Login Activity",
          route: `${route("dashboard")}`,
        },
        {
          name: "Emails From Instagram",
          route: `${route("dashboard")}`,
        },
        {
          name: "Log Out",
          route: `${route("logout")}`,
        },
      ],
    };
  },
  methods: {
    close() {
      // your code to close the modal
      this.$emit("close-modal");
    },
  },
};
</script>

<style>
</style>