import router from "@/router";
import axios from "axios";
import auth from "./auth";
const state = {
  userLists: {},
  profile:{},
  types:[],
  errors:[],
  createData:{},
  updateData:{},
  invalidPass:'',
};

const mutations = {
  setUserList(state,data) {
    state.userLists = data;
  },
  getTypeList(state,data) {
    state.types = data;
  },
  setErrors(state,error) {
    state.errors = error;
  },
  clearErrors(state) {
    state.errors = [];
  },
  setCreateData(state,data) {
    state.createData = data;
  },
  setUpdateData(state,data) {
    state.updateData = data;
  },
  setProfile(state,data) {
    state.profile = data;
  },
  setInvalid(state,data) {
    state.invalidPass = data;
  }
};

const actions = {

  /**
   * Get profile (user) detail
   * @param mixed commit
   * @param int payloadID
   * @return void
   */
  getProfile({ commit }, payloadID) {
    return axios
      .get(`user/${payloadID}`)
      .then((value) => {
        if (value.status === 200) {
          commit('setProfile',value.data.user);
        }
        return value;
      })
      .catch((error) => {
        return error.response;
      });
  },

  /**
   * Search and pagination user lists
   * @param mixed commit
   * @param int payload
   * @return void
   */
  searchUser({commit},payload) {
    return axios.get('users',{params:payload}).then((value) => {
      if (value.status == 200) {
        commit('setUserList',value.data.users);
      }
    }).catch((error) => {
      if(error.response.status === 401) {
        commit('auth/logout',null,{root:true});
        localStorage.clear();
        router.push("/login");
      }
    })
  },

  /**
   * Get all user type
   * @param mixed commit
   * @return void
   */
  getType({commit}) {
    return axios.get("user/type").then((value) => {
      if (value.status === 200) {
        commit('getTypeList',value.data.types);
      }
    }).catch((error) => {
      
    })
  },

  /**
   * Get create-user data from api
   * @param mixed commit
   * @return void
   */
  getCreateData({commit}) {
    return axios.get("user/create/data").then((value) => {
      if (value.status === 200) {
        if (!value.data.user) {
          return router.push("/user/create");
        }
        commit('setCreateData',value.data.user);
      }
    }).catch((error) => {
    })
  },

  /**
   * Get update-user data from api
   * @param mixed commit
   * @return void
   */
  getUpdateData({commit}) {
    return axios.get("user/update/data").then((value) => {
      if (value.status === 200) {
        if (!value.data.user) {
          return router.push("/users");
        }
        commit('setUpdateData',value.data.user);
      }
    }).catch((error) => {
    })
  },

  /**
   * Create user
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  confirmCreate({commit},payload) {
    return axios.post("user/create/data",payload).then((value) => {
      if (value.status === 200) {
        return router.push("/users");
      }
    }).catch((error) => {
    })
  },

  /**
   * Update user
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  confirmUpdate({commit},payload) {
    return axios.post(`user/${payload.id}/update`,payload.data).then((value) => {
      if (value.status === 200) {
        return router.push("/users");
      }
    }).catch((error) => {
    })
  },

  /**
   * Send create-user data to cache in api
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  createUser({commit},payload) {
    return axios.post("user",payload).then((value) => {
      if (value.status === 200) {
        return value;
      }
    }).catch((error) => {
      commit('setErrors',error.response.data.error);
    })
  },

  /**
   * Send update-user data to cache in api
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  updateUser({commit},payload) {
    return axios.post(`user/${payload.id}`,payload.data).then((value) => {
      if (value.status === 200) {
        return value;
      }
    }).catch((error) => {
      commit('setErrors',error.response.data.error);
    })
  },

  /**
   * Delete user
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  deleteUser({commit},payload) {
    return axios.delete(`user/${payload}`).then((value) => {
      if (value.status === 200) {
        return value;
      }
    }).catch((error) => {
    })
  },

  /**
   * Change password
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  changePassword({commit},payload) {
    return axios.put('user/password',payload).then((value) => {
      if (value.status === 200) {
        return value;
      }
    }).catch((error) => {
      if (error.response.status === 401) {
        commit('setInvalid',error.response.data.error.oldPass);
        commit('setErrors',[]);
        return;
      }
      commit('setErrors',error.response.data.error);
    })
  }
};

const getters = {};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
