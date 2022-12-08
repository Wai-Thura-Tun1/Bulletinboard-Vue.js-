<template>
  <div class="flex flex-col mt-20 ml-20 text-left">
    <PopUp v-if="deleteModal" :title="'Delete Post'" :text="'Are you sure to delete?'" @closebox="deleteModal=false" @confirmbox="deletePost"></PopUp>
    <DetailPop v-if="detailModal" @closedetail="detailModal=false" :post="postDetail"/>
    <div class="flex flex-col">
      <h2 class="w-full text-xl font-bold text-left">Post Lists</h2>
      <div class="flex mt-5 space-x-5">
        <div>
          <input class="px-2 py-1 border border-gray-400 rounded-sm w-52" v-model="search" placeholder="">
        </div>
        <div>
          <button class="px-5 py-1 text-white bg-blue-500 rounded-md" @click="searchPost">
            Search
          </button>
        </div>
        <div>
          <button class="px-5 py-1 text-white bg-blue-500 rounded-md">
            <router-link to="/post/create">Add</router-link>
          </button>
        </div>
        <div>
          <button class="px-5 py-1 text-white bg-blue-500 rounded-md">
            <router-link to="/post/upload">Upload</router-link>
          </button>
        </div>
        <div>
          <button class="px-5 py-1 text-white bg-blue-500 rounded-md" @click="exportPost">
            Download
          </button>
        </div>
      </div>
    </div>
    <table class="inline-block mt-10">
      <thead class="">
        <th class="w-32 p-1 truncate border border-gray-400">Post Title</th>
        <th class="w-48 p-1 truncate border border-gray-400">Post Description</th>
        <th class="p-1 truncate border border-gray-400 w-28">Posted User</th>
        <th class="p-1 truncate border border-gray-400 w-28">Posted Date</th>
        <th class="w-24 p-1 truncate border border-gray-400"></th>
        <th class="w-24 p-1 truncate border border-gray-400"></th>
      </thead>
      <tbody class="">
        <tr v-for="post in postData.data" :key="post.id">
          <td class="w-32 p-1 text-blue-500 underline truncate border border-gray-400 cursor-pointer">
            <div @click="showDetail(post.id)">{{ post.title }}</div>
          </td>
          <td class="w-48 p-1 truncate border border-gray-400">{{ post.description }}</td>
          <td class="p-1 truncate border border-gray-400 w-28">{{ post.created_user.name }}</td>
          <td class="p-1 truncate border border-gray-400 w-28">{{ post.posttime }}</td>
          <td class="w-24 p-1 text-center truncate border border-gray-400">
            <router-link :to="{name: 'PostEdit',params:{id:post.id}}" class="text-blue-500 underline cursor-pointer">Edit</router-link>
          </td>
          <td class="w-24 p-1 text-center truncate border border-gray-400">
            <div class="text-blue-500 underline cursor-pointer" @click="(deleteModal=true,deleteId=post.id)">Delete</div>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="mt-5">
      <advanced-laravel-vue-paginate :data="postData" :previousText="'<<'" :nextText="'>>'" @paginateTo="searchPost" />
    </div>
  </div>
</template>

<script>
import AdvancedLaravelVuePaginate from 'advanced-laravel-vue-paginate'
import PopUp from '../common/PopUp.vue';
import DetailPop from '@/components/Post/PostDetail.vue';
import { mapState } from 'vuex';
export default {
  data(){
    return {
      search:'',
      deleteModal:false,
      deleteId:0,
      detailModal:false,
    }
  },
  components:{
    AdvancedLaravelVuePaginate,
    PopUp,
    DetailPop
  },
  computed:{
    ...mapState({
      postData:(state) => state.post.postList,
      postDetail:(state) => state.post.postDetail,
    })
  },
  beforeMount(){
    this.searchPost();
  },
  methods:{
    
    /**
     * Search and pagination posts
     * @return void
     */
    async searchPost(page = 1) {
      const paraPayload = {
        search:this.search,
        page: page,
      }
      await this.$store.dispatch('post/searchPost',paraPayload);
      return;
    },

    /**
     * Get post detail
     * @param int id
     * @return void
     */
    async showDetail(id) {
      await this.$store.dispatch('post/getPost',id);
      this.detailModal = true;
      return;
    },

    /**
     * Delete post
     * @return void
     */
    async deletePost() {
      this.deleteModal = false;
      await this.$store.dispatch("post/deletePost",this.deleteId);
      await this.searchPost();
      return;
    },

    /**
     * Export post as excel file
     * @return void
     */
    async exportPost() {  
      let response = await this.$store.dispatch("post/exportPost"); 
      const aTag = document.createElement('a');
      const url = window. URL. createObjectURL(
        new Blob([response.data])
      );
      aTag.href = url;
      aTag.setAttribute('download','posts.xlsx');
      document.body.appendChild(aTag);
      aTag.click();
      window.URL.revokeObjectURL(url);
      aTag.remove();
      return;
    }
  }
}
</script>

<style>

</style>