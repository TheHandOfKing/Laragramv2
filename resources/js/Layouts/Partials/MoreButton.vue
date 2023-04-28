<template>
  <div class="more-button">
    <div>
      <a href="#" role="link" tabindex="0">
        <div @click="toggleModal" class="flex justify-start">
          <div>
            <div
              class="x9f619 xjbqb8w x78zum5 x168nmei x13lgxp2 x5pf9jr xo71vjh x1n2onr6 x1plvlek xryxfnj x1c4vz4f x2lah0s xdt5ytf xqjyukv x1qjc9v5 x1oa3qoh x1nhvcw1"
            >
              <div class="x9f619 xxk0z11 xvy4d1p x11xpdln xii2z7h x19c4wfv">
                <svg
                  aria-label="Settings"
                  class="_ab6-"
                  color="rgb(245, 245, 245)"
                  fill="rgb(245, 245, 245)"
                  height="24"
                  role="img"
                  viewBox="0 0 24 24"
                  width="24"
                >
                  <line
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    x1="3"
                    x2="21"
                    y1="4"
                    y2="4"
                  ></line>
                  <line
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    x1="3"
                    x2="21"
                    y1="12"
                    y2="12"
                  ></line>
                  <line
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    x1="3"
                    x2="21"
                    y1="20"
                    y2="20"
                  ></line>
                </svg>
              </div>
            </div>
          </div>
          <div class="more-text ml-6" style="opacity: 1">
            <div style="width: 100%">
              <div>More</div>
            </div>
          </div>
        </div></a
      >
      <div v-if="isClicked" class="more-info">
        <div class="more-options-modal">
          <div v-for="(item, index) in menuItems" :key="index">
            <a
              class="p-3 flex justify-between"
              :href="item.route"
              role="link"
              tabindex="0"
            >
              <div class="flex justify-between w-full">
                <span>{{ item.name }}</span>

                <div v-html="item.svg"></div></div
            ></a>
          </div>
          <a
            class="x1i10hfl x1qjc9v5 xjbqb8w xjqpnuy xa49m3k xqeqjp1 x2hbi6w x13fuv20 xu3j5b3 x1q0q8m5 x26u7qi x972fbf xcfux6l x1qhh985 xm0m39n x9f619 x1ypdohk xdl72j9 x2lah0s xe8uvvx xdj266r x11i5rnm xat24cr x1mh8g0r x2lwn1j xeuugli xexx8yu x4uap5 x18d9i69 xkhd6sd x1n2onr6 x16tdsg8 x1hl2dhg xggy1nq x1ja2u2z x1t137rt x1q0g3np x87ps6o x1lku1pv x1a2a7pz xh8yej3 x193iq5w x1lliihq x1dm5mii x16mil14 xiojian x1yutycm"
            href="#"
            role="link"
            tabindex="0"
          >
            <ResponsiveNavLink
              :href="route('logout')"
              method="post"
              as="button"
            >
              Log Out
            </ResponsiveNavLink>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
export default {
  components: { ResponsiveNavLink },
  data() {
    return {
      isClicked: false,

      menuItems: [
        {
          name: "Settings",
          svg: `<svg
            aria-label="Settings"
            class="x1lliihq x1n2onr6"
            color="#000"
            fill="#000"
            height="24"
            role="img"
            viewBox="0 0 24 24"
            width="24"
          >
            <circle
              cx="12"
              cy="12"
              fill="none"
              r="8.635"
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
            ></circle>
            <path
              d="M14.232 3.656a1.269 1.269 0 0 1-.796-.66L12.93 2h-1.86l-.505.996a1.269 1.269 0 0 1-.796.66m-.001 16.688a1.269 1.269 0 0 1 .796.66l.505.996h1.862l.505-.996a1.269 1.269 0 0 1 .796-.66M3.656 9.768a1.269 1.269 0 0 1-.66.796L2 11.07v1.862l.996.505a1.269 1.269 0 0 1 .66.796m16.688-.001a1.269 1.269 0 0 1 .66-.796L22 12.93v-1.86l-.996-.505a1.269 1.269 0 0 1-.66-.796M7.678 4.522a1.269 1.269 0 0 1-1.03.096l-1.06-.348L4.27 5.587l.348 1.062a1.269 1.269 0 0 1-.096 1.03m11.8 11.799a1.269 1.269 0 0 1 1.03-.096l1.06.348 1.318-1.317-.348-1.062a1.269 1.269 0 0 1 .096-1.03m-14.956.001a1.269 1.269 0 0 1 .096 1.03l-.348 1.06 1.317 1.318 1.062-.348a1.269 1.269 0 0 1 1.03.096m11.799-11.8a1.269 1.269 0 0 1-.096-1.03l.348-1.06-1.317-1.318-1.062.348a1.269 1.269 0 0 1-1.03-.096"
              fill="none"
              stroke="currentColor"
              stroke-linejoin="round"
              stroke-width="2"
            ></path>
          </svg>`,
          route: `${route("profile.edit")}`,
        },
        {
          name: "Your Activity",
          svg: `<svg
            aria-label="Your activity"
            class="x1lliihq x1n2onr6"
            color="#000"
            fill="#000"
            height="24"
            role="img"
            viewBox="0 0 24 24"
            width="24"
          >
            <title>Your activity</title>
            <path
              d="M12 1.505a10.5 10.5 0 1 1-7.424 17.924"
              fill="none"
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
            ></path>
            <polyline
              fill="none"
              points="8.893 15.108 12 12 12.012 12.012 12.012 5.793"
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
            ></polyline>
            <circle cx="7.24" cy="2.651" r="1.125"></circle>
            <circle cx="3.515" cy="5.83" r="1.125"></circle>
            <circle cx="1.636" cy="10.353" r="1.125"></circle>
            <circle cx="2.01" cy="15.235" r="1.125"></circle>
          </svg>`,
          route: "",
        },
        {
          name: "Saved",
          svg: `<svg
            aria-label="Saved"
            class="x1lliihq x1n2onr6"
            color="#000"
            fill="#000"
            height="24"
            role="img"
            viewBox="0 0 24 24"
            width="24"
          >
            <title>Saved</title>
            <polygon
              fill="none"
              points="20 21 12 13.44 4 21 4 3 20 3 20 21"
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
            ></polygon>
          </svg>`,
          route: "",
        },
        {
          name: "Switch Appereance",
          svg: `<svg
            aria-label="Theme icon"
            class="x1lliihq x1n2onr6"
            color="#000"
            fill="#000"
            height="24"
            role="img"
            viewBox="0 0 16 16"
            width="24"
          >
            <title>Theme icon</title>
            <path
              d="M8.05 16C3.61 16 0 12.39 0 7.95 0 3.99 2.83.65 6.72 0c.49-.03.87.22.99.6.11.38-.05.78-.41 1-1.7.93-2.75 2.69-2.75 4.61 0 2.89 2.35 5.25 5.25 5.25a5.25 5.25 0 0 0 4.61-2.74c.19-.37.61-.54 1.01-.4.42.14.66.56.58 1.01A8.044 8.044 0 0 1 8.05 16zM5.8 1.32c-2.78.93-4.73 3.56-4.73 6.63 0 3.85 3.13 6.99 6.99 6.99 3.04 0 5.66-1.93 6.61-4.72a6.301 6.301 0 0 1-4.87 2.31c-3.48 0-6.31-2.83-6.31-6.31-.01-1.93.86-3.71 2.31-4.9zm9.54 7.89s0 .01 0 0c0 .01 0 0 0 0z"
              fill="currentColor"
            ></path>
          </svg>`,
          route: "",
        },
        {
          name: "Report a Problem",
          svg: `<svg
            aria-label="Report a problem"
            class="x1lliihq x1n2onr6"
            color="#000"
            fill="#000"
            height="24"
            role="img"
            viewBox="0 0 24 24"
            width="24"
          >
            <title>Report a problem</title>
            <path
              d="M18.001 1h-12a5.006 5.006 0 0 0-5 5v9.005a5.006 5.006 0 0 0 5 5h2.514l2.789 2.712a1 1 0 0 0 1.394 0l2.787-2.712h2.516a5.006 5.006 0 0 0 5-5V6a5.006 5.006 0 0 0-5-5Zm3 14.005a3.003 3.003 0 0 1-3 3h-2.936a1 1 0 0 0-.79.387l-2.274 2.212-2.276-2.212a1 1 0 0 0-.79-.387H6a3.003 3.003 0 0 1-3-3V6a3.003 3.003 0 0 1 3-3h12a3.003 3.003 0 0 1 3 3Zm-9-1.66a1.229 1.229 0 1 0 1.228 1.228A1.23 1.23 0 0 0 12 13.344Zm0-8.117a1.274 1.274 0 0 0-.933.396 1.108 1.108 0 0 0-.3.838l.347 4.861a.892.892 0 0 0 1.77 0l.348-4.86a1.106 1.106 0 0 0-.3-.838A1.272 1.272 0 0 0 12 5.228Z"
            ></path>
          </svg>`,
          route: "",
        },
        {
          name: "Switch Accounts",
          svg: ``,
          route: "",
        },
      ],
    };
  },

  methods: {
    toggleModal() {
      if (this.isClicked) {
        this.isClicked = false;
      } else {
        this.isClicked = true;
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.more-button {
  .more-info {
    bottom: 115px;
    position: absolute;
    -webkit-box-shadow: 6px 6px 15px 5px rgba(0, 0, 0, 0.49);
    -moz-box-shadow: 6px 6px 15px 5px rgba(0, 0, 0, 0.49);
    box-shadow: 6px 6px 15px 5px rgba(0, 0, 0, 0.49);
    background: #fff;
  }
}

.more-options-modal {
  padding: 20px;
  min-width: 238px;
  display: flex;
  flex-direction: column;
}
</style>