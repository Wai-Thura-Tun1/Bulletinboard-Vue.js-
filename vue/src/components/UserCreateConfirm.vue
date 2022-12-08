<template>
  <div class="py-10 px-28"> 
    <div class="flex justify-between">
      <h2 class="text-xl font-bold">Create User Confirmation</h2>
      <img class="w-40 h-40 rounded-sm" :src="createdData.profile">
    </div>
    <div class="flex flex-col ml-20 text-left space-y-7">
      <div class="flex ">
        <div class="w-60">Name</div>
        <div>{{ createdData.name }}</div>
      </div>
      <div class="flex ">
        <div class="w-60">Email Address</div>
        <div>{{ createdData.email }}</div>
      </div>
      <div class="flex ">
        <div class="w-60">Password</div>
        <div>{{ createdData.pass }}</div>
      </div>
      <div class="flex ">
        <div class="w-60">Type</div>
        <div>{{ createdData.type }}</div>
      </div>
      <div class="flex ">
        <div class="w-60">Phone</div>
        <div>{{ createdData.phone ?? "null" }}</div>
      </div>
      <div class="flex ">
        <div class="w-60">Date Of Birth</div>
        <div>{{ createdData.dob ?? "null" }}</div>
      </div>
      <div class="flex ">
        <div class="w-60">Address</div>
        <div>{{ createdData.address ?? "null" }}</div>
      </div>
      <div class="flex mt-10 space-x-10">
        <button @click="confirmCreate" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:opacity-80">
          Create
        </button>
        <button type="button" @click="cancelCreate" class="px-4 py-2 border border-green-500 rounded-md hover:bg-green-500 hover:text-white">
          Cancel
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  computed:{
    ...mapState({
      createdData: (state) => state.user.createData
    })
  },
  beforeMount() {
    this.$store.dispatch('user/getCreateData');
  },
  methods:{
    /**
     * Create user
     * @return void
     */
    async confirmCreate() {
      const data = {
        name : this.createdData.name,
        email : this.createdData.email,
        password : this.createdData.pass,
        profile : this.createdData.profile,
        type : this.createdData.typeid,
        phone : this.createdData.phone,
        address : this.createdData.address,
        dob : this.createdData.dob,
      }
      await this.$store.dispatch("user/confirmCreate",data);
    },

    /**
     * Go back to previous page
     * @return void
     */
    cancelCreate() {
      this.$router.go(-1);
    }
  }
}
</script>

<style>

</style>