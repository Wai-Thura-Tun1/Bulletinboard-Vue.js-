<template>
  <div class="ml-20 text-left">
    <h2 class="mt-10 text-2xl font-bold">Update User</h2>
    <form @submit.prevent="updateUser">
      <div class="flex flex-col mt-5 mb-20 ml-10 space-y-5">
        <div class="flex space-x-20">
          <div class="w-48">
            Name
          </div>
          <div>
            <div class="flex items-center space-x-2">
              <input type="text" v-model="name" placeholder="" class="px-2 py-1 border rounded-sm w-60" :class="[errors['name'] ? 'border-red-600' : 'border-gray-400']">
              <span class="text-2xl text-red-500">*</span>
            </div>
            <div v-if="errors['name']" class="text-sm text-red-600">{{ errors['name'][0] }}</div>
          </div>
        </div>
        <div class="flex space-x-20">
        <div class="w-48">
          Email Address
        </div>
        <div>
          <div class="flex items-center space-x-2">
            <input type="email" v-model="email" placeholder="" class="px-2 py-1 border rounded-sm w-60" :class="[errors['email'] ? 'border-red-600' : 'border-gray-400']">
            <span class="text-2xl text-red-500">*</span>
          </div>
          <div v-if="errors['email']" class="text-sm text-red-600">{{ errors['email'][0] }}</div>
        </div>
        </div>
        <div v-if="false" class="flex space-x-20">
        <div class="w-48">
          Password
        </div>
        <div>
          <div class="flex items-center space-x-2">
            <input type="password" placeholder="" v-model="pass" class="px-2 py-1 border rounded-sm w-60" :class="[errors['pass'] ? 'border-red-600' : 'border-gray-400']">
            <span class="text-2xl text-red-500">*</span>
          </div>
          <div v-if="errors['pass']" class="text-sm text-red-600">{{ errors['pass'][0] }}</div>
        </div>
        </div>
        <div v-if="false" class="flex space-x-20">
        <div class="w-48">
          Confirm Password
        </div>
        <div>
          <div class="flex items-center space-x-2">
            <input type="password" placeholder="" v-model="cpass" class="px-2 py-1 border rounded-sm w-60" :class="[errors['cpass'] ? 'border-red-600' : 'border-gray-400']">
            <span class="text-2xl text-red-500">*</span>
          </div>
          <div v-if="errors['cpass']" class="text-sm text-red-600">{{ errors['cpass'][0] }}</div>
        </div>
        </div>
        <div class="flex space-x-20">
          <div class="w-48">
            Type
          </div>
          <div>
            <div class="flex items-center space-x-2">
              <select v-model="user_type" class="px-2 py-1 border rounded-sm w-60" :class="[errors['type'] ? 'border-red-600' : 'border-gray-400']">
                <option selected>Select Type</option>
                <option :selected="user_type==index" v-for="(type,index) in types" :key="index" :value="index">{{ type }}</option>
              </select>
              <span class="text-2xl text-red-500">*</span>
            </div>
            <div v-if="errors['type']" class="text-sm text-red-600">{{ errors['type'][0] }}</div>
          </div>
        </div>
        <div class="flex space-x-20">
        <div class="w-48">
          Phone
        </div>
        <div>
          <input type="text"  v-model="phone" placeholder="" class="px-2 py-1 border rounded-sm w-60" :class="[errors['phone'] ? 'border-red-600' : 'border-gray-400']">
          <div v-if="errors['phone']" class="text-sm text-red-600">{{ errors['phone'][0] }}</div>
        </div>
        </div>
        <div class="flex space-x-20">
          <div class="w-48">
            Date Of Birth
          </div>
          <div>
            <input type="date" placeholder="" v-model="dob" class="px-2 py-1 border rounded-sm w-60" :class="[errors['dob'] ? 'border-red-600' : 'border-gray-400']">
            <div v-if="errors['dob']" class="text-sm text-red-600">{{ errors['dob'][0] }}</div>
          </div>
        </div>
        <div class="flex space-x-20">
          <div class="w-48">
            Address
          </div>
          <div>
            <textarea placeholder="" v-model="address" class="h-20 px-2 py-1 border rounded-sm resize-none w-60" :class="[errors['address'] ? 'border-red-600' : 'border-gray-400']"></textarea>
            <div v-if="errors['address']" class="text-sm text-red-600">{{ errors['address'][0] }}</div>
          </div>
        </div>
        <div class="flex space-x-20">
          <div class="w-48">
            Profile
          </div>
          <div>
              <div>
                <div class="flex items-center mb-3 space-x-2">
                  <input type="file" ref="profileHold" @change="previewProfile" placeholder="Email" class="px-2 py-1 border rounded-sm w-60" :class="[errors['profile'] ? 'border-red-600' : 'border-gray-400']">
                  <span class="text-2xl text-red-500">*</span>
                </div>
                <div v-if="errors['profile']" class="text-sm text-red-600">{{ errors['profile'][0] }}</div>
              </div>
              <div class="">
                <img v-if="profile" class="w-40 h-40" :src="profile">
              </div>
          </div>
        </div>
        <div class="flex space-x-20">
          <router-link v-if="getUserID===editId" class="text-blue-500 underline" to="/user/change/password">Change password</router-link>
        </div>
        <div class="flex space-x-20">
          <div class="w-48">
          </div>
          <div>
              <div class="flex mt-10 space-x-10">
                <button class="px-4 py-2 text-white bg-blue-500 rounded-md hover:opacity-80">
                  Confirm
                </button>
                <button type="button" @click="clearForm" class="px-4 py-2 border border-green-500 rounded-md hover:bg-green-500 hover:text-white">
                  Clear
                </button>
              </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  data() {
    return {
      profile:"",
      rawProfile:null,
      name:"",
      email:"",
      address:"",
      phone:"", 
      dob:"",
      user_type:"",
      pass:"",
      cpass:"",
      editId:this.$route.params.id
    }
  },
  computed:{
    ...mapState({
      types: (state) => state.user.types,
      errors: (state) => state.user.errors,
      getUserID: (state) => state.auth.id,
    })
  },
  beforeMount(){
    this.$store.dispatch('user/getType');
    this.getData();
  },
  methods:{
    /**
     * Preview image from input tag
     * @param mixed e
     * @return void
     */
    previewProfile(e) {
      let profileRaw = e.target.files[0];
      let reader = new FileReader();
      this.rawProfile = profileRaw;
      console.log(this.rawProfile);
      reader.readAsDataURL(profileRaw);
      reader.onload = (e) => {
        this.profile = e.target.result;
      } 
    },

    /**
     * Clear all inputs
     * @return void
     */
    clearForm() {
      this.name = "";
      this.email = "";
      this.pass = "";
      this.cpass = "";
      this.profile = "";
      this.phone = "";
      this.address = "";
      this.dob = "";
      this.user_type = "";
      this.profileRaw = "";
      this.$refs.profileHold.value = null;
      this.$store.commit('user/clearErrors');
    },

    /**
     * Get profile (user) detail
     * @return void
     */
    async getData() {
      let response = await this.$store.dispatch(
        "user/getProfile",
        this.$route.params.id
      );
      if (response.status === 200) {
        let data = response.data.user;
        this.name = data.name;
        this.email = data.email;
        this.phone = data.phone ?? "";
        this.user_type = data.type;
        this.address = data.address ?? "";
        this.dob = data.dob ?? "";
        this.profile = data.profile;
      }
      else {
        this.$store.commit("auth/logout");
        localStorage.clear();
        this.$router.push("/login");
      }
    },  

    /**
     * Send update-user data to cache in api
     * @return void
     */
    async updateUser() {
      let fd = new FormData();
      fd.append('_method','PUT');
      fd.append('id',this.$route.params.id);
      fd.append('name',this.name);
      fd.append('email',this.email);
      fd.append('type',this.user_type);
      fd.append('phone',this.phone);
      fd.append('address',this.address);
      fd.append('dob',this.dob);
      fd.append('profile',this.rawProfile ?? '');
      const updateData = {
        data:fd,
        id:this.$route.params.id
      }
      let response = await this.$store.dispatch('user/updateUser',updateData);
      if (response) {
        if (response.status == 200) {
          this.$router.push('/user/update/confirm');
        } 
      }
    }
  }
}
</script>

<style>

</style>