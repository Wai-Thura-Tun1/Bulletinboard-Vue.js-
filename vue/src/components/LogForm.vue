<template>
  <div class="px-5 py-10">
    <form @submit.prevent="handleLogin" class="w-full text-left">
      <h3 class="mb-8 text-xl font-bold">Login Form</h3>
      <div class="flex flex-col w-full space-y-5">
        <div v-if="loginFailed" class="flex justify-between">
          <div class=""></div>
          <div class="flex flex-col w-4/6 space-y-1 text-lg text-red-500">
            {{ loginFailed }}
          </div>
        </div>
        <div class="flex justify-between">
          <div class="">Email</div>
          <div class="flex flex-col w-4/6 space-y-1">
            <div class="flex items-center space-x-2">
              <input
                type="email"
                v-model="email"
                class="w-full px-1.5 py-1 rounded-sm border border-gray-400"
                placeholder="Email"
              />
              <span class="text-2xl text-red-500">*</span>
            </div>
            <div class="text-sm text-red-600" v-if="errorEmail">{{ errorEmail }}</div>
          </div>
        </div>
        <div class="flex justify-between">
          <div class="">Password</div>
          <div class="flex flex-col w-4/6 space-y-1">
            <div class="flex items-center space-x-2">
              <input
                type="password"
                v-model="pass"
                class="w-full px-1.5 py-1 rounded-sm border border-gray-400"
                placeholder="Password"
              />
              <span class="text-2xl text-red-500">*</span>
            </div>
            <div class="text-sm text-red-600" v-if="errorPass">{{ errorPass }}</div>
          </div>
        </div>
        <div class="flex items-center justify-between">
          <div class="invisible">option</div>
          <div class="flex flex-col w-4/6 space-y-3">
            <div class="flex items-center space-x-3">
              <input type="checkbox" v-model="remember" />
              <label class="text-sm">Remember Me</label>
            </div>
            <div class="underline text-sky-500"></div>
            <div>
              <button class="px-5 py-2 text-white bg-blue-500 rounded-sm">
                Login
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  data() {
    return {
      email: "",
      pass: "",
      remember: false,
    };
  },
  computed: {
    ...mapState({
      errorEmail: (state) => state.auth.email,
      errorPass: (state) => state.auth.pass,
      loginFailed:(state) => state.auth.loginStatus
    }),
  },
  methods: {
    async handleLogin() {
      this.$store.commit('toggleLoading',true);
      const data = {
        email: this.email,
        password: this.pass,
        remember_me: this.remember,
      };
      let response = await this.$store.dispatch("auth/logIn", data);
      if(response) {
        this.$store.commit('toggleLoading',false);
        if (response.status === 200) {
          localStorage.setItem("token", response.data.token);
          localStorage.setItem("type", response.data.type);
          localStorage.setItem("user_name", response.data.user_name);
          localStorage.setItem("credential_id", response.data.id);
          this.email = this.pass = "";
          this.remember = false;
          this.$store.commit("auth/login");
          this.$router.push("/");
        }
        
      }
    },
  },
};
</script>

<style>
</style>