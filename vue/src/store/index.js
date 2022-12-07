
import Vue from "vue";
import Vuex from "vuex";
import auth from './modules/auth';
import user from './modules/user';
import post from './modules/post';
Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    isLoading:false,
  },
  getters: {  
  },
  mutations: {
    toggleLoading(state,data = false) {
      state.isLoading = data;
    }
  },
  actions: {
  },
  modules: {
    auth,
    user,
    post
  },
});
