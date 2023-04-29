import { createStore } from 'vuex';
import createPostModal from './createPostModal';
const store = createStore({
  modules: {
    createPostModal
  },
});

export default store;