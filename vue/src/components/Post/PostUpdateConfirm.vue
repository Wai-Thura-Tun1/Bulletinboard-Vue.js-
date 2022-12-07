<template>
  <div class="py-10 px-28"> 
    <div class="flex justify-between mb-10">
      <h2 class="text-xl font-bold">Update Post Confirmation</h2>
    </div>
    <form @submit.prevent="confirmUpdate">
      <div class="flex flex-col ml-20 text-left space-y-7">
        <div class="flex ">
          <div class="w-60">Title</div>
          <div>{{ updatedPost.title }}</div>
        </div>
        <div class="flex ">
          <div class="w-60">Description</div>
          <div>{{ updatedPost.description }}</div>
        </div>
        <div class="flex ">
          <div class="w-60">Status</div>
          <div>
            <label for="checkStatus" class="relative px-6 py-1 border cursor-pointer rounded-2xl broder-black" :class="[status ? 'bg-green-500' : 'bg-gray-500']"><span class="absolute p-3 bg-white rounded-full" :class="[status ? 'right-0' : 'left-0']"></span></label>
            <input id="checkStatus" class="hidden" v-model="status" type="checkbox">
          </div>
        </div>
        <div class="flex mt-10 space-x-10">
          <button class="px-4 py-2 text-white bg-blue-500 rounded-md hover:opacity-80">
            Update
          </button>
          <button type="button" @click="cancelUpdate" class="px-4 py-2 border border-green-500 rounded-md hover:bg-green-500 hover:text-white">
            Cancel
          </button>
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
      status:true
    }
  },
  beforeMount(){
    this.updatedPostData();
  },
  computed:{
    ...mapState({
      updatedPost: (state) => state.post.updatedPost,
    }),
  },
  methods:{ 
    async updatedPostData(){
      let response = await this.$store.dispatch("post/getUpdatedPost");
      if (response && response.status === 200) {
        response.data.post.status == 1 ? this.status = true : this.status = false;
      }
    },
    cancelUpdate() {
      this.$router.push({name:'PostEdit', params:{id:this.updatedPost.id}});
    },
    async confirmUpdate() {
      const confirmData = {
        data:{
          title:this.updatedPost.title,
          description:this.updatedPost.description,
          status:this.status
        },
        id:this.updatedPost.id
      }
      await this.$store.dispatch("post/confirmUpdatePost",confirmData);
    }
  }
}
</script>

<style>

</style>