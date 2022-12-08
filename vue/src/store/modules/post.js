import router from "@/router";
import axios from "axios";
import auth from "./auth";
const state = {
  postList: {},
  postDetail: {},
  errors: {},
  createdPost: {},
  updatedPost: {},
};

const mutations = {
  setPostList(state, data) {
    state.postList = data;
  },
  setPostDetail(state, data) {
    state.postDetail = data;
  },
  setErrors(state, data) {
    state.errors = data;
  },
  setCreatedPost(state, data) {
    state.createdPost = data;
  },
  setUpdatedPost(state, data) {
    state.updatedPost = data;
  },
};

const actions = {
  /**
   * Search and pagination posts
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  searchPost({ commit }, payload) {
    return axios
      .get("posts", { params: payload })
      .then((value) => {
        if (value.status === 200) {
          commit("setPostList", value.data.posts);
          return;
        }
      })
      .catch((error) => {
        if (error.response.status === 401) {
          commit("auth/logout", null, { root: true });
          localStorage.clear();
          router.push("/login");
        }
      });
  },

  /**
   * Get post detail
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  getPost({ commit }, payload) {
    return axios
      .get(`post/${payload}`)
      .then((value) => {
        if (value.status === 200) {
          commit("setPostDetail", value.data.post);
          return value;
        }
      })
      .catch((error) => {});
  },

  /**
   * Send create-post data to cache in api
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  createPost({ commit }, payload) {
    return axios
      .post("post", payload)
      .then((value) => {
        if (value.status === 200) {
          return value;
        }
      })
      .catch((error) => {
        commit("setErrors", error.response.data.error);
      });
  },

  /**
   * Send update-post data to cache in api
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  updatePost({ commit }, payload) {
    return axios
      .put(`post/${payload.id}`, payload.data)
      .then((value) => {
        if (value.status === 200) {
          return value;
        }
      })
      .catch((error) => {
        commit("setErrors", error.response.data.error);
      });
  },

  /**
   * Get create-post data from api
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  getCreatedPost({ commit }) {
    return axios
      .get("post/create/data")
      .then((value) => {
        if (value.status === 200) {
          if (!value.data.post) {
            return router.push("/post/create");
          }
          commit("setCreatedPost", value.data.post);
          return value;
        }
      })
      .catch((error) => {});
  },

  /**
   * Get update-post data from api
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  getUpdatedPost({ commit }) {
    return axios
      .get("post/update/data")
      .then((value) => {
        if (value.status === 200) {
          if (!value.data.post) {
            return router.push("/");
          }
          commit("setUpdatedPost", value.data.post);
          return value;
        }
      })
      .catch((error) => {});
  },

  /**
   * Create post
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  confirmCreatePost({ commit }, payload) {
    return axios
      .post("post/create/data", payload)
      .then((value) => {
        if (value.status === 200) {
          router.push("/");
          return value;
        }
      })
      .catch((error) => {});
  },

  /**
   * Update post
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  confirmUpdatePost({ commit }, payload) {
    return axios
      .post(`post/${payload.id}/update`, payload.data)
      .then((value) => {
        if (value.status === 200) {
          return router.push("/");
        }
      })
      .catch((error) => {});
  },

  /**
   * Upload post using csv file
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  uploadCSV({ commit }, payload) {
    return axios
      .post("posts", payload)
      .then((value) => {
        if (value.status === 200) {
          return router.push("/");
        }
      })
      .catch((error) => {
        if (error.response.status === 400) {
          commit("setErrors", error.response.data.error);
        }
      });
  },

  /**
   * Delete post
   * @param mixed commit
   * @param Object payload
   * @return void
   */
  deletePost({ commit }, payload) {
    return axios
      .delete(`post/${payload}`)
      .then((value) => {
        if (value.status === 200) {
          return value;
        }
      })
      .catch((error) => {});
  },

  /**
   * Export post as excel file
   * @param mixed commit
   * @return void
   */
  exportPost({ commit }) {
    return axios
      .get("posts/excel", {
        responseType: "blob",
      })
      .then((value) => {
        if (value.status === 200) {
          return value;
        }
      })
      .catch((error) => {});
  },
};

const getters = {};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
