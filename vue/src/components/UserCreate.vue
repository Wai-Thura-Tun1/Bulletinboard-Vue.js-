<template>
  <div class="ml-20 text-left">
    <h2 class="mt-10 text-2xl font-bold">Create User</h2>
    <form @submit.prevent="createUser">
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
        <div class="flex space-x-20">
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
        <div class="flex space-x-20">
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
                <option v-for="(type,index) in types" :key="index" :value="index">{{ type }}</option>
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
      profile:'',
      rawProfile:null,
      name:'',
      email:'',
      address:'',
      phone:'', 
      dob:'',
      user_type:'',
      pass:"",
      cpass:''
    }
  },
  computed:{
    ...mapState({
      types: (state) => state.user.types,
      errors: (state) => state.user.errors
    })
  },
  beforeMount(){
    this.$store.dispatch('user/getType');
  },
  methods:{
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
    async createUser() {
      let fd = new FormData();
      fd.append('name',this.name);
      fd.append('email',this.email);
      fd.append('pass',this.pass);
      fd.append('cpass',this.cpass);
      fd.append('type',this.user_type);
      fd.append('phone',this.phone);
      fd.append('address',this.address);
      fd.append('dob',this.dob);
      fd.append('profile',this.rawProfile ?? '');
      let response = await this.$store.dispatch('user/createUser',fd);
      if (response) {
        if (response.status == 200) {
          this.$router.push('/user/create/confirm');
        } 
      }  
    },
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
    }
  }
}
</script>

<style>

</style>