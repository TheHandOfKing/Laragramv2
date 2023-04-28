<template>
  <div class="profile-item-wrap p-3">
    <Link
      class=""
      :href="route('profile', $page.props.auth.user.slug)"
      role="link"
      tabindex="0"
      ><div
        class="x9f619 x3nfvp2 xr9ek0c xjpr12u xo237n4 x6pnmvc x7nr27j x12dmmrz xz9dl7a xn6708d xsag5q8 x1ye3gou x1l895ks x159b3zp xdoji71 x1dejxi8 x9k3k5o xs3sg5q x11hdxyr x12ldp4w x1wj20lx x1dn74xm xif99yt x172qv1o x10djquj x1lhsz42 xzauu7c x1z11no5 xjy5m1g x1mnwbp6 x4pb5v6"
      >
        <div class="flex flex-row justify-start">
          <span class="circle mr-6"
            ><img
              alt="s's profile picture"
              class="x6umtig x1b1mbwd xaqea5y xav7gou xk390pu x5yr21d xpdipgo xdj266r x11i5rnm xat24cr x1mh8g0r xexx8yu x4uap5 x18d9i69 xkhd6sd x11njtxf xh8yej3"
              :src="$page.props.auth.user.profilePicture"
            />
          </span>
          <span>
            <div class="_aacl _aacp _adda _aacx _aada">Profile</div>
          </span>
        </div>
      </div></Link
    >
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
export default {
  components: { Link },
  props: ["src"],
};
</script>

<style lang="scss" scoped>
.circle {
  border-radius: 1000px;
  border: 1px solid #000;
  width: 25px;
  height: 25px;
}

img {
  width: 100%;
  height: 100%;
  border-radius: 1000px;
}
</style>