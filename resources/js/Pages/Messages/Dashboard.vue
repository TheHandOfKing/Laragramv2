<template>
  <Head :title="pageTitle" />
  <AuthenticatedLayout>
    <div class="messages relative">
      <chat-modal @close-modal="closeChatModal" v-if="chatModal"></chat-modal>
      <div class="message-box flex">
        <div class="chat-options">
          <div class="profile">
            <div class="flex wrap">
              <div class="mr-5"></div>
              <div class="profile-name">
                {{ $page.props.auth.user.username }}
              </div>
              <div class="compose-message ml-6">
                <button>
                  <div>
                    <svg
                      aria-label="New message"
                      class="x1lliihq x1n2onr6"
                      color="rgb(245, 245, 245)"
                      fill="rgb(245, 245, 245)"
                      height="24"
                      role="img"
                      viewBox="0 0 24 24"
                      width="24"
                    >
                      <title>New message</title>
                      <path
                        d="M12.202 3.203H5.25a3 3 0 0 0-3 3V18.75a3 3 0 0 0 3 3h12.547a3 3 0 0 0 3-3v-6.952"
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                      ></path>
                      <path
                        d="M10.002 17.226H6.774v-3.228L18.607 2.165a1.417 1.417 0 0 1 2.004 0l1.224 1.225a1.417 1.417 0 0 1 0 2.004Z"
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                      ></path>
                      <line
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        x1="16.848"
                        x2="20.076"
                        y1="3.924"
                        y2="7.153"
                      ></line>
                    </svg>
                  </div>
                </button>
              </div>
            </div>
          </div>
          <div class="chat-users" v-if="options.length > 0">
            <chat-option
              v-for="(option, index) in options"
              :key="index"
              :option="option"
              @click="test(option.receiver)"
            ></chat-option>
          </div>
          <div class="no-chat" v-else>
            <div class="no-chat-text text-white p-6">
              No chats, find a person to chat with.
            </div>
          </div>
        </div>
        <div
          v-if="currentChatter != null"
          class="chat-content flex flex-col w-full"
        >
          <div class="chat-header flex w-full p-2 border">
            <div class="user-data">
              <Link
                class="flex items-center"
                :href="route('profile', currentChatter)"
              >
                <img
                  style="border-radius: 50%; height: 44px; width: 44px"
                  class="mr-2"
                  :src="currentChatter.profilePicture"
                  alt="profile-image"
                />
                <span
                  >{{ currentChatter.name }},
                  {{ currentChatter.username }}</span
                >
              </Link>
            </div>
            <div class="options"></div>
          </div>
          <div class="chat-content h-full">
            <chat :messages="messages"></chat>
          </div>
          <div class="chat-input flex border">
            <input
              type="text"
              v-model="newMessage"
              @keydown.enter="sendMessage"
            />
            <button @click="sendMessage">Send</button>
          </div>
        </div>

        <compose-chat @openModal="openModal" v-else></compose-chat>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ChatOption from "@/Pages/Messages/Partials/ChatOption.vue";
import ComposeChat from "@/Pages/Messages/Partials/ComposeChat.vue";
import ChatModal from "@/Pages/Messages/Partials/ChatModal.vue";
import Chat from "@/Pages/Messages/Partials/Chat.vue";
import { Head, Link } from "@inertiajs/vue3";

export default {
  props: ["chats", "users"],
  components: {
    Head,
    Link,
    AuthenticatedLayout,
    ChatOption,
    Chat,
    ComposeChat,
    ChatModal,
  },
  computed: {
    currentChatter() {
      return this.$store.getters["setUsersChat/getChatUser"];
    },
  },
  data() {
    return {
      options: this.chats,
      selectedUser: {},
      messages: [],
      chatModal: false,
    };
  },

  methods: {
    test(user) {
      console.log(user);
      axios.get("/api/chat/" + user.id).then((response) => {
        console.log(response);
        this.messages = response.data;
        this.$store.dispatch("setUsersChat/startChat", user);
      });

      // window.Echo.private(`messages.${user.id}`).listen("NewMessage", (e) => {
      //   this.handleIncomingMessage(e.message);
      // });
    },

    handleIncomingMessage(message) {
      this.messages.push(message);
    },

    openModal() {
      this.chatModal = true;
    },

    closeChatModal() {
      this.chatModal = false;
    },
  },
};
</script>

<style lang="scss" scoped>
.messages {
  margin-left: 190px;
  display: flex;
  justify-content: center;
  padding: 20px;
  align-items: center;
  height: 100vh;

  .message-box {
    height: 100%;
    max-width: 935px;
    width: 100%;
    border: 1px solid black;
    border-radius: 4px;
    flex-direction: row;

    .chat-options {
      align-items: stretch;
      background-color: rgb(0, 0, 0);
      border: 0;
      border-right: 1px solid rgb(54, 54, 54);
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      flex-shrink: 0;
      font: inherit;
      font-size: 100%;
      height: 100%;
      margin: 0;
      overflow: hidden;
      padding: 0;
      position: relative;
      vertical-align: baseline;
      width: 350px;

      .chat-users {
        overflow-y: scroll;
      }

      .chat-users::-webkit-scrollbar {
        width: 5px;
      }

      .chat-users::-webkit-scrollbar-track {
        background: #f1f1f1;
      }

      .chat-users::-webkit-scrollbar-thumb {
        background: #5f5f5f;
        border-radius: 5px;
      }

      .chat-users::-webkit-scrollbar-thumb:hover {
        background: #555;
      }

      .profile {
        background-color: rgb(0, 0, 0);
        border-bottom: 1px solid rgb(54, 54, 54);
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        font-size: 16px;
        font-weight: 600;
        height: 60px;
        padding: 0 20px;
        width: 100%;
        z-index: 2;

        .wrap {
          align-items: center;
          display: flex;
          flex-direction: row;
          height: inherit;
          justify-content: space-between;
          width: 100%;

          .profile-name {
            align-items: center;
            color: rgb(255, 255, 255);
            display: inline-block;
            flex-basis: 0px;
            flex-grow: 1;
            flex-shrink: 1;
            justify-content: center;
            min-width: 0;
            overflow: hidden;
            text-align: center;
            text-overflow: ellipsis;
            white-space: nowrap;
          }
        }
      }
    }

    .chat-content {
    }
  }
}
</style>