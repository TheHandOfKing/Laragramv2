<template>
  <div class="option">
    <div class="p-4">
      <div class="option-item flex">
        <div class="content flex">
          <div class="username" style="width: 54px; height: 54px">
            <div class="profile-data flex items-center">
              <img
                class="mr-2"
                style="border-radius: 50%"
                :src="option.receiver.profilePicture"
                alt="profile-image"
              />
            </div>
          </div>
          <div class="message-date text-white flex flex-col ml-4">
            <div class="username">{{ option.receiver.username }}</div>
            <div class="wrap flex">
              <div v-if="option.messages.length > 0" class="message">
                <div class="date">{{ option.messages }}</div>
                <div class="date">52m</div>
              </div>
              <div v-else class="message">
                <small>Start Chatting!</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
export default {
  props: ["option"],
  components: { Link },
};
</script>

<style>
.option {
  cursor: pointer;
}
</style>