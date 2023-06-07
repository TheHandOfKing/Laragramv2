<template>
  <!-- Default Modal -->
  <div
    id="medium-modal"
    tabindex="-1"
    class="fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center"
  >
    <div class="relative w-full max-w-lg max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div
          class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600"
        >
          <h3 class="text-xl font-medium text-gray-900 dark:text-white">
            New Message
          </h3>
          <button
            @click="closeModal"
            type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-hide="medium-modal"
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
        <div class="p-6 space-y-6">
          <div class="search flex items-center">
            To:
            <input
              type="text"
              v-model="search"
              @keyup="fetchData"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 ml-5"
              placeholder="Search"
            />
          </div>

          <div class="user-list" v-if="users.length > 0">
            <user-to-chat
              @start-chat="startChat"
              v-for="(user, index) in users"
              :key="index"
              :user="user"
            ></user-to-chat>
          </div>
          <div class="no-found" v-else>No account found.</div>
        </div>
        <!-- Modal footer -->
        <div
          class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600"
        >
          <button
            data-modal-hide="medium-modal"
            type="button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full"
          >
            Chat
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import UserToChat from "./UserToChat.vue";
import _ from "lodash";

export default {
  components: {
    UserToChat,
  },
  data() {
    return {
      users: [],
      search: "",
    };
  },

  methods: {
    closeModal() {
      this.$emit("closeModal");
    },
    startChat(user) {
      axios
        .post("/api/chat", { other_chatter_id: user.id })
        .then((response) => {
          this.$store.dispatch("setUsersChat/startChat", user);
        })
        .catch((error) => {
          console.error(error);
        });
    },

    fetchData: _.debounce(function () {
      axios
        .get(this.route("api.users"), {
          params: {
            search: this.search,
          },
        })
        .then((response) => {
          this.users = [];
          this.users = response.data;
        })
        .catch((error) => {
          console.error(error);
        });
    }, 300), // Adjust this delay as needed
  },
};
</script>

<style>
.user-list {
  overflow-y: scroll;
  height: 200px;
}

.user-list::-webkit-scrollbar {
  width: 5px;
}

.user-list::-webkit-scrollbar-track {
  background: #f1f1f1;
}

.user-list::-webkit-scrollbar-thumb {
  background: #5f5f5f;
  border-radius: 5px;
}

.user-list::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>