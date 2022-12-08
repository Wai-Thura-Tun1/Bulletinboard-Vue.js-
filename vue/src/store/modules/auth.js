import axios from "axios";
const state = {
  user_name: null,
  token: null,
  type: false,
  id:null,
  email: "",
  pass: "",
  loginStatus:"",
};

const actions = {

  /**
   * Logout user and commit logout mutation
   * @param mixed commit
   * @return void
   */
  logOut({ commit }) {
    return axios.post("user/logout").then((value) => {
      if (value.status === 200) {
        commit('logout')
        return value;
      }
    }).catch((error) => {
    })
  },

  /**
   * Login user and commit login mutation
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  logIn({ commit }, payload) {
    return axios
      .post("user/login", payload)
      .then((value) => value)
      .catch((error) => {
        commit("clearError");
        if(error.response.status === 400) {
          let errorValue = error.response.data.error;
          commit("addError", errorValue);
        }
        else if (error.response.status === 401) {
          commit("addLoginStatus",error.response.data.message);
        }
        return error.response;
      });
  },
};

const mutations = {
  logout(state) {
    state.user_name = null;
    state.token = null;
    state.type = null;
    state.id = null;
  },
  login(state) {
    state.user_name = localStorage.getItem("user_name");
    state.token = localStorage.getItem("token");
    state.type = localStorage.getItem("type");
    state.id = localStorage.getItem("credential_id");
  },
  addError(state, error) {
    (state.email = error.email[0]), (state.pass = error.password[0]);
  },
  clearError(state) {
    state.email = "";
    state.pass = "";
    state.loginStatus = "";
  },
  addLoginStatus(state,error) {
    state.loginStatus = error;
  }
};

const getters = {
  getUserName(state) {
    return state.user_name;
  },
  getToken(state) {
    return state.token;
  },
  getType(state) {
    return state.type;
  },
  getID(state) {
    return state.id;
  },
};

export default {
  namespaced: true,
  state,
  actions,
  mutations,
  getters,
};
