const savePostImageData = {
  namespaced: true,
  state: {
    postImage: [],
    postImageUrl: [],
  },

  mutations: {
    SAVE_POST_IMAGE(state, data) {
      state.postImage = [];
      state.postImage.push(data);
    },
    SAVE_POST_IMAGE_URL(state, data) {
      state.postImageUrl = [];
      state.postImageUrl.push(data);
    },

  },
  actions: {
    savePostImageAction({ commit }, data) {
      commit('SAVE_POST_IMAGE', data);
    },

    savePostImageUrlAction({ commit }, data) {
      commit('SAVE_POST_IMAGE_URL', data);
    },
  },
  getters: {
    getPostImage: (state) => {
      return state.postImage;
    },
    getPostImageUrl: (state) => {
      return state.postImageUrl;
    },
  }
};

export default savePostImageData;