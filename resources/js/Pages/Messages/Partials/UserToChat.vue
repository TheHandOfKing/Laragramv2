<template>
  <div class="warp cursor-pointer" @click="startChat()">
    <div class="user-part flex">
      <div class="image"><img :src="user.profilePicture" alt="" /></div>
      <div class="username flex flex-col ml-5">
        <div>{{ user.name }}</div>
        <div>{{ user.username }}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["user"],

  methods: {
    startChat() {
      this.$emit("start-chat", this.user);
    },
  },
};
</script>

<style lang="scss" scoped>
.warp {
  height: 60px;
  margin-top: 1rem;
  margin-bottom: 1rem;

  .user-part {
    width: 100%;
    height: 100%;

    img {
      object-fit: cover;
      height: 100%;
      border-radius: 50%;
    }
  }
}
</style>