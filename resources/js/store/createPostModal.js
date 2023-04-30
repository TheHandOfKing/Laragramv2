const createPostModal = {
  namespaced: true,
  state: {
    createPostModal: false,
  },
  mutations: {
    CLOSE_CREATE_MODAL(state) {
      state.createPostModal = false;
    },

    OPEN_CREATE_MODAL(state) {
      state.createPostModal = true;
    },
  },
  actions: {
    closeCreateModalAction({ commit }) {
      commit('CLOSE_CREATE_MODAL');
    },
    openCreateModalAction({ commit }) {
      commit('OPEN_CREATE_MODAL');
    },
  },
  getters: {
    // Your getters here
  },
};

export default createPostModal;