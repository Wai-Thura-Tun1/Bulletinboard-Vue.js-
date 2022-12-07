<template>
  <div class="py-10 px-28"> 
    <div class="flex justify-between mb-10">
      <h2 class="text-xl font-bold">Create Post Confirmation</h2>
    </div>
    <form @submit.prevent="confirmCreatePost">
      <div class="flex flex-col ml-20 text-left space-y-7">
        <div class="flex ">
          <div class="w-60">Title</div>
          <div>{{ createdPost.title }}</div>
        </div>
        <div class="flex ">
          <div class="w-60">Description</div>
          <div>{{ createdPost.description }}</div>
        </div>
        <div class="flex mt-10 space-x-10">
          <button class="px-4 py-2 text-white bg-blue-500 rounded-md hover:opacity-80">
            Create
          </button>
          <button type="button" class="px-4 py-2 border border-green-500 rounded-md hover:bg-green-500 hover:text-white">
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
  computed:{
    ...mapState({
      createdPost:(state) => state.post.createdPost,
    })
  },
  beforeMount(){
    this.$store.dispatch("post/getCreatedPost");
  },
  methods:{
    async confirmCreatePost() {
      const data = {
        title:this.createdPost.title,
        description: this.createdPost.description,
      }
      await this.$store.dispatch("post/confirmCreatePost",data);
    }
  }
}
</script>

<style>

</style>