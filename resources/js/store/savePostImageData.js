const savePostImageData = {
  namespaced: true,
  state: {
    postImage: {}
  },
  mutations: {
    SAVE_POST_IMAGE(state, data) {
      state.postImage = data;
    },

  },
  actions: {
    savePostImageAction({ commit }, data) {
      commit('SAVE_POST_IMAGE', data);
    },
  },
  getters: {
    // Your getters here
  },
};

export default savePostImageData;