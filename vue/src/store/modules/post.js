import router from "@/router";
import axios from "axios";
import auth from "./auth";
const state = {
  postList:{},
  postDetail:{},
  errors:{},
  createdPost:{},
  updatedPost:{}
}

const mutations = {
  setPostList(state,data) {
    state.postList = data;
  },
  setPostDetail(state,data) {
    state.postDetail = data;
  },
  setErrors(state,data) {
    state.errors = data;
  },
  setCreatedPost(state,data) {
    state.createdPost = data;
  },
  setUpdatedPost(state,data) {
    state.updatedPost = data;
  }
}

const actions = {
  searchPost({commit},payload) {
    return axios.get("posts",{params: payload}).then((value) => {
      if (value.status === 200) {
        commit('setPostList',value.data.posts);
      }
    }).catch((error) => {
      if(error.response.status === 401) {
        commit('auth/logout',null,{root:true});
        localStorage.clear();
        router.push("/login");
      }
    })
  },

  getPost({commit},payload) {
    return axios.get(`post/${payload}`).then((value) => {
      if (value.status === 200) {
        commit('setPostDetail',value.data.post);
        return value;
      }
    }).catch((error) => {
    })
  },

  createPost({commit},payload) {
    return axios.post('post',payload).then((value) => {
      if (value.status === 200) {
        return value;
      }
    }).catch((error) => {
      commit('setErrors',error.response.data.error);
    });
  },

  updatePost({commit},payload) {
    return axios.put(`post/${payload.id}`,payload.data).then((value) => {
      if (value.status === 200) {
        return value;
      }
    }).catch((error) => {
      commit('setErrors',error.response.data.error);
    });
  },

  getCreatedPost({commit}) {
    return axios.get('post/create/data').then((value) => {
      if (value.status === 200) {
        if (!value.data.post) {
          return router.push('/post/create');
        }
        commit('setCreatedPost',value.data.post);
        return value;
      }
    }).catch((error) => {
    })
  },

  getUpdatedPost({commit}) {
    return axios.get('post/update/data').then((value) => {
      if (value.status === 200) {
        if (!value.data.post) {
          return router.push('/');
        }
        commit('setUpdatedPost',value.data.post);
        return value;
      }
    }).catch((error) => {
    })
  },

  confirmCreatePost({commit},payload) {
    return axios.post('post/create/data',payload).then((value) => {
      if (value.status === 200) {
        router.push('/');
        return value;
      }
    }).catch((error) => {
    })
  },

  confirmUpdatePost({commit},payload) {
    return axios.post(`post/${payload.id}/update`,payload.data).then((value) => {
      if (value.status === 200) {
        return router.push('/');
      }
    }).catch((error) => {
    })
  },

  uploadCSV({commit},payload) {
    return axios.post('posts',payload).then((value) => {
      if (value.status === 200) {
        return router.push('/');
      }
    }).catch((error) => {
      if (error.response.status === 400) {
        commit('setErrors',error.response.data.error);
      }
    });
  },

  deletePost({commit},payload) {
    return axios.delete(`post/${payload}`).then((value) => {
      if (value.status === 200) {
        return value;
      }
    }).catch((error) => {
    })
  },

  exportPost({commit}) {
    return axios.get('posts/excel',{
      responseType: 'blob',
    }).then((value) => {
      if (value.status === 200) {
        return value;
      }
    }).catch((error) => {
    });
  }
}

const getters = {

}

export default {
  namespaced:true,
  state,
  mutations,
  actions,
  getters
}