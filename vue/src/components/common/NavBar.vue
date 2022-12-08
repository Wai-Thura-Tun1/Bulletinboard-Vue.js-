<template>
  <div>
    <PopUp v-if="showModal" :title="'Log out'" :text="'Are you sure to log out?'" @closebox="showModal=false" @confirmbox="logoutUser" @cancelbox="showModal=false"></PopUp>
    <div class="sticky top-0 flex items-center justify-between p-4 bg-white border-b border-black ">
    <div class="flex flex-row items-center space-x-5">
      <h1 class="text-2xl font-bold">SCM Bulletin Board</h1>
      <div v-if="getType == 0 && getToken" class="relative px-2 text-blue-500 underline">
        <router-link :to="{ name: 'User' }">Users</router-link>
      </div>
      <div v-if="getToken" class="relative px-2 text-blue-500 underline">
        <router-link :to="{ name: 'Profile' }">User</router-link>
      </div>
      <div v-if="getToken" class="relative px-2 text-blue-500 underline">
        <router-link :to="{ name: 'Post' }">Posts</router-link>
      </div>
    </div>
    <div v-if="getToken" class="flex flex-row space-x-5">
      <div>
        {{ getUser }}
      </div>
      <div class="text-blue-500 underline cursor-pointer" @click="showModal=true">Logout</div>
    </div>
  </div>
  </div>

</template>

<script>
import PopUp from './PopUp.vue';
export default {
  data(){
    return {
      showModal:false
    }
  },
  components:{
    PopUp
  },
  computed: {
    getUser() {
      return this.$store.getters["auth/getUserName"];
    },
    getToken() {
      return this.$store.getters["auth/getToken"];
    },
    getType() {
      return this.$store.getters["auth/getType"];
    },
    
  },
  mounted() {
    this.$store.commit("auth/login");
  },
  methods: {

    /**
     * Logout user
     * @return void
     */
    async logoutUser() {
      this.showModal = false;
      let response = await this.$store.dispatch("auth/logOut");
      if (response.status === 200) {
        localStorage.clear();
        this.$router.push("/login");
        return;
      }
    },
  },
};
</script>

<style>
</style>