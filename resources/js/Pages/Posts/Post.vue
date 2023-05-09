<template>
  <div class="flex justify-center post-wrap flex-col">
    <div class="top-profile-info">
      <div class="profile-data flex items-center">
        <img :src="post.user.profilePicture" alt="" />
        <span>{{ post.user.username }}</span>
      </div>
    </div>
    <img class="post-image" :src="post.mainImage" alt="" />
  </div>
</template>

<script>
export default {
  props: ["post"],
};
</script>

<style lang="scss" scoped>
.post-wrap {
  border-radius: 30px;
  border: 1px solid gray;
  max-width: 468px;

  .top-profile-info {
    height: 40px;
    border-bottom: 1px solid gray;
  }

  .post-image {
    height: 585px;
    object-fit: cover;
  }

  .profile-data {
    width: 408px;

    img {
      width: 32px;
      object-fit: cover;
      height: 32px;
      border-radius: 50%;
    }
  }
}
</style>