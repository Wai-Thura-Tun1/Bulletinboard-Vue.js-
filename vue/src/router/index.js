import Vue from "vue";
import VueRouter from "vue-router";
import LoginView from "../views/LoginView.vue";
import UserList from "../views/UserList.vue";
import Profile from "../views/ProfileView.vue";
import UserCreate from "../views/UserCreateView.vue";
import UserCreateConfirm from "../views/UserCreateConfirm.vue";
import ChangePass from "../views/ChangePassView.vue";
import UserUpdateConfirm from "../views/UserUpdateConfirm.vue";
import UserEdit from "../views/UserEditView.vue";
import PostList from "../views/Post/PostListView.vue";
import PostCreate from "../views/Post/PostCreateView.vue";
import PostCreateConfirm from "../views/Post/PostCreateConfirmView.vue";
import PostEdit from "../views/Post/PostUpdateView.vue";
import PostUpdateConfirm from "../views/Post/PostUpdateConfirmView.vue";
import PostUpload from "../views/Post/PostUploadView.vue";
import addHeader from "@/axios";
Vue.use(VueRouter);

const routes = [
  {
    path: "/login",
    name: "Login",
    component: LoginView,
  },
  {
    path: "/users",
    name: "User",
    component: UserList,
  },
  {
    path: "/",
    name: "Post",
    component: PostList,
  },
  {
    path: "/user",
    name: "Profile",
    component: Profile,
  },
  {
    path: "/user/create",
    name: "UserCreate",
    component: UserCreate,
  },
  {
    path: "/post/create",
    name: "PostCreate",
    component: PostCreate,
  },

  {
    path: "/user/change/password",
    name: "ChangePass",
    component: ChangePass,
  },
  {
    path: "/user/create/confirm",
    name: "UserCreateConfirm",
    component: UserCreateConfirm
  },
  {
    path: "/post/create/confirm",
    name: "PostCreateConfirm",
    component: PostCreateConfirm
  },
  {
    path: "/post/update/confirm",
    name: "PostUpdateConfirm",
    component: PostUpdateConfirm
  },
  {
    path: "/user/update/confirm",
    name: "UserUpdateConfirm",
    component: UserUpdateConfirm
  },
  {
    path: "/user/:id/edit",
    name: "UserEdit",
    component: UserEdit
  },
  {
    path: "/post/:id/edit",
    name: "PostEdit",
    component: PostEdit
  },
  {
    path:"/post/upload",
    name:"PostUpload",
    component: PostUpload
  }
];

const router = new VueRouter({
  routes,
  mode: "history",
});

router.beforeEach((to, from, next) => {
  addHeader();
  let auth = localStorage.getItem('token');
  let id = parseInt(localStorage.getItem('type'));
  if (to.name !== "Login" && !auth) {
    next('/login');
  }
  else if (to.name === "Login" && auth){
    next("/");
  }
  else if (to.name === "User") {
    if (id !== 0) {
      next("/");
    }
    else {
      next();
    }
  }
  else {
    next();
  }
});

export default router;
