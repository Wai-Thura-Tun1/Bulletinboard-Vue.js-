<template>
  <div class="ml-20 text-left">
    <h2 class="mt-10 text-2xl font-bold">Create Post</h2>
    <form @submit.prevent="createPost">
      <div class="flex flex-col mt-5 mb-20 ml-10 space-y-5">
        <div class="flex space-x-20">
          <div class="w-48">
            Title
          </div>
          <div>
            <div class="flex items-center space-x-2">
              <input type="text" placeholder="" v-model="title" class="px-2 py-1 border rounded-sm w-60" :class="[errors['title'] ? 'border-red-500' : 'border-black']">
              <span class="text-2xl text-red-500">*</span>
            </div>
            <div v-if="errors['title']" class="text-sm text-red-600">{{ errors['title'][0] }}</div>
          </div>
        </div>
        <div class="flex space-x-20">
          <div class="w-48">
            Description
          </div>
          <div>
            <textarea placeholder="" v-model="description" class="h-20 px-2 py-1 border rounded-sm resize-none w-60" :class="[errors['description'] ? 'border-red-500' : 'border-black']"></textarea>
            <div v-if="errors['description']" class="text-sm text-red-600">{{ errors['description'][0] }}</div>
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
import { mapState } from 'vuex'
export default {
  data(){
    return {
      title:'',
      description:'',
    }
  },
  computed:{
    ...mapState({
      errors:(state) => state.post.errors,
    })
  },
  methods:{

    /**
     * Clear all inputs
     * @return void
     */
    clearForm() {
      this.title = '',
      this.description = ''
      return;
    },

    /**
     * Send create-post data to cache in api
     * @return void
     */
    async createPost() {
      const data = {
        title:this.title,
        description:this.description
      }
      let response = await this.$store.dispatch("post/createPost",data);
      if (response.status === 200) {
        return this.$router.push("/post/create/confirm");
      }
    },
  }
}
</script>

<style>

</style>