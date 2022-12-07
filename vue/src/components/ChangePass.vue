<template>
  <div class="mt-10 ml-20 text-left">
    <h2 class="text-xl font-bold">Change Password</h2>
    <form @submit.prevent="changePass">
      <div class="flex flex-col mt-5 ml-10 space-y-5">
        <div class="flex space-x-10">
          <div class="w-40">
            Old Password
          </div>
          <div>
            <div class="flex items-center space-x-2">
              <input type="password" v-model="oldPass" placeholder="" class="px-2 py-1 border rounded-sm w-60">
              <span class="text-2xl text-red-500">*</span>
            </div>
            <div v-if="(errors['oldPass'])" class="text-sm text-red-600">{{ errors['oldPass'][0] }}</div>
            <div v-if="invalidOld" class="text-sm text-red-600">{{ invalidOld }}</div>
          </div>
        </div>
        <div class="flex space-x-10">
          <div class="w-40">
            New Password
          </div>
          <div>
            <div class="flex items-center space-x-2">
              <input type="password" v-model="newPass" placeholder="" class="px-2 py-1 border rounded-sm w-60">
              <span class="text-2xl text-red-500">*</span>
            </div>
            <div v-if="errors['newPass']" class="text-sm text-red-600">{{ errors['newPass'][0] }}</div>
          </div>
        </div>
        <div class="flex space-x-10">
          <div class="w-40">
            Confirm Password
          </div>
          <div>
            <div class="flex items-center space-x-2">
              <input type="password" v-model="confirmPass" placeholder="" class="px-2 py-1 border rounded-sm w-60">
              <span class="text-2xl text-red-500">*</span>
            </div>
            <div v-if="errors['confirmPass']" class="text-sm text-red-600">{{ errors['confirmPass'][0] }}</div>
          </div>
        </div>
        <div class="flex mt-10 space-x-10">
          <div class="w-40">
          </div>
          <div class="flex space-x-5">
            <button class="px-2 py-1 text-white bg-blue-500 rounded-sm">Confirm</button>
            <button class="px-2 py-1 border border-black rounded-sm">Cancel</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  data(){
    return {
      oldPass:'',
      newPass:'',
      confirmPass:''
    }
  },
  computed:{
    ...mapState({
      errors:(state) => state.user.errors,
      invalidOld: (state) => state.user.invalidPass
    })
  },
  methods:{
    async changePass() {
      const data = {
        newPass:this.newPass,
        oldPass:this.oldPass,
        confirmPass:this.confirmPass
      }
      let response = await this.$store.dispatch('user/changePassword',data);
      if (response) {
        if(response.status === 200) {
          this.$router.push("/");
        }
      }
    }
  }
}
</script>

<style>

</style>