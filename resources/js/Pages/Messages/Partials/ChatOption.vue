<template>
  <div class="option">
    <Link>
      <div class="p-4">
        <div class="option-item flex">
          <div class="content flex">
            <div class="username" style="width: 54px; height: 54px">
              <Link class="profile-data flex items-center">
                <img
                  class="mr-2"
                  style="border-radius: 50%"
                  :src="$page.props.auth.user.profilePicture"
                  alt="profile-image"
                />
                <span></span>
              </Link>
            </div>
            <div class="message-date text-white flex flex-col">
              <div class="username">Kruks</div>
              <div class="wrap flex">
                <div class="message">:D</div>
                <div class="date">52m</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Link>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
export default {
  components: { Link },
};
</script>

<style>
</style>