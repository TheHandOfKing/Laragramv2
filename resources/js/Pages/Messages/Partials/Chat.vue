<template>
  <div class="row flex justify-center">Date</div>
  <div class="message flex items-center">
    <div class="profile inline-flex">
      <Link
        :style="isUser ? 'display: none;' : ''"
        class="flex items-center"
        :href="route('profile', $page.props.auth.user.id)"
      >
        <img
          style="border-radius: 50%; height: 44px; width: 44px"
          class="mr-2"
          :src="$page.props.auth.user.profilePicture"
          alt="profile-image"
        />
        <span>Marko Pavlovic, 24</span>
      </Link>
    </div>
    <div class="message-content ml-4 mr-4">asdasdasdasdsad</div>
  </div>
</template>

<script>
export default {};
</script>

<style>
.user {
  justify-content: start;
}

.receiver {
  justify-content: end;
  flex-direction: row-reverse;
}
</style>