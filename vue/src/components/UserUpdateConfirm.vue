<template>
  <div class="py-10 px-28"> 
    <div class="flex justify-between">
      <h2 class="text-xl font-bold">Create User Confirmation</h2>
      <img class="w-40 h-40 rounded-sm" :src="updatedData.profile">
    </div>
    <div class="flex flex-col ml-20 text-left space-y-7">
      <div class="flex ">
        <div class="w-60">Name</div>
        <div>{{ updatedData.name }}</div>
      </div>
      <div class="flex ">
        <div class="w-60">Email Address</div>
        <div>{{ updatedData.email }}</div>
      </div>
      <div v-if="false" class="flex ">
        <div class="w-60">Password</div>
        <div>{{ updatedData.pass }}</div>
      </div>
      <div class="flex ">
        <div class="w-60">Type</div>
        <div>{{ updatedData.type }}</div>
      </div>
      <div class="flex ">
        <div class="w-60">Phone</div>
        <div>{{ updatedData.phone ?? "null" }}</div>
      </div>
      <div class="flex ">
        <div class="w-60">Date Of Birth</div>
        <div>{{ updatedData.dob ?? "null" }}</div>
      </div>
      <div class="flex ">
        <div class="w-60">Address</div>
        <div>{{ updatedData.address ?? "null" }}</div>
      </div>
      <div class="flex mt-10 space-x-10">
        <button @click="confirmUpdate" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:opacity-80">
          Update
        </button>
        <button type="button" @click="cancelUpdate" class="px-4 py-2 border border-green-500 rounded-md hover:bg-green-500 hover:text-white">
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
      updatedData: (state) => state.user.updateData
    })
  },
  beforeMount() {
    this.$store.dispatch('user/getUpdateData');
  },
  methods:{
    async confirmUpdate() {
      const updateData = {
        data:{
          name : this.updatedData.name,
          email : this.updatedData.email,
          profile : this.updatedData.profile,
          type : this.updatedData.typeid,
          phone : this.updatedData.phone,
          address : this.updatedData.address,
          dob : this.updatedData.dob,
        },
        id:this.updatedData.id
      }
      await this.$store.dispatch("user/confirmUpdate",updateData);
    },
    cancelUpdate() {
      this.$router.push({name:'UserEdit', params:{id:this.updatedData.id}});
    }
  }
}
</script>

<style>

</style>