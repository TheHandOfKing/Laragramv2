import { createStore } from 'vuex';
import createPostModal from './createPostModal';
import savePostImageData from './savePostImageData';
const store = createStore({
  modules: {
    createPostModal,
    savePostImageData
  },
});

export default store;