import { createStore } from 'vuex';
import createPostModal from './createPostModal';
import savePostImageData from './savePostImageData';
import setUsersChat from './setUsersChat';
const store = createStore({
  modules: {
    createPostModal,
    savePostImageData,
    setUsersChat
  },
});

export default store;