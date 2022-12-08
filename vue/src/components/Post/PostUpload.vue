<template>
  <div class="ml-20 text-left">
    <h2 class="mt-10 text-2xl font-bold">Upload CSV File</h2>
    <form class="inline-block px-10 py-5 mt-5 mb-20 ml-20 border border-black" @submit.prevent="uploadPost">
      <div class="flex flex-col space-y-10">
        <div>
          <input type="file" @change="selectCSVFile"> 
          <div v-if="errors['data']" class="mt-1 text-sm text-red-600">{{ errors['data'][0] }}</div>
        </div>
        <div class="flex ml-10 space-x-10">
          <button class="px-4 py-2 text-white bg-blue-500 rounded-md hover:opacity-80">
            Import File
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
      postfile:""
    }
  },
  computed:{
    ...mapState({
      errors:(state) => state.post.errors,  
    })
  },
  methods:{

    /**
     * Add selected-file to postfile 
     * @return void
     */
    selectCSVFile(e) {
      this.postfile = e.target.files[0];
      return;
    },

    /**
     * Upload post using csv file
     * @return void
     */
    async uploadPost() {
      let fd = new FormData();
      fd.append('data',this.postfile);
      await this.$store.dispatch("post/uploadCSV",fd);
      return;
    }
  }  
}
</script>

<style>

</style>