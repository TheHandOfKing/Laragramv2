const setUsersChat = {
  namespaced: true,
  state: {
    chatUser: null,
  },

  mutations: {
    SET_CHAT_USER(state, user) {
      state.chatUser = user;
    },
  },

  actions: {
    startChat({ commit }, user) {
      commit('SET_CHAT_USER', user);
    },
  },

  getters: {
    getChatUser: (state) => {
      return state.chatUser;
    },
  }
};

export default setUsersChat;