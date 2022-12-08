<template>
  <div class="flex flex-col mt-20 ml-20 text-left">
    <PopUp v-if="deleteModal" :title="'Delete user'" :text="'Are you sure to delete?'" @closebox="deleteModal=false" @confirmbox="deleteUser"></PopUp>
    <div class="flex flex-col">
      <h2 class="w-full text-xl font-bold text-left">User List</h2>
      <div class="flex mt-5 space-x-5">
        <div>
          <input class="w-40 px-2 py-1 border border-gray-400 rounded-sm" v-model="name" placeholder="Name"/>
        </div>
        <div>
          <input class="w-40 px-2 py-1 border border-gray-400 rounded-sm" v-model="email" placeholder="Email"/>
        </div>
        <div>
          <input class="w-40 px-2 py-1 border border-gray-400 rounded-sm" v-model="from" placeholder="Created From"/>
        </div>
        <div>
          <input class="w-40 px-2 py-1 border border-gray-400 rounded-sm" v-model="to" placeholder="Created To"/>
        </div>
        <div>
          <button class="px-5 py-1 text-white bg-blue-500 rounded-md" @click="searchUser">
            Search
          </button>
        </div>
        <div>
          <button class="px-5 py-1 text-white bg-blue-500 rounded-md">
            <router-link to="/user/create">Add</router-link>
          </button>
        </div>
      </div>
    </div>
    <table class="inline-block mt-10">
      <thead class="">
        <th class="p-1 truncate border border-gray-400 w-28">Name</th>
        <th class="p-1 truncate border border-gray-400 w-44">Email</th>
        <th class="p-1 truncate border border-gray-400 w-28">Created User</th>
        <th class="p-1 truncate border border-gray-400 w-28">Phone</th>
        <th class="p-1 truncate border border-gray-400 w-28">Birth Date</th>
        <th class="p-1 truncate border border-gray-400 w-44">Address</th>
        <th class="w-32 p-1 truncate border border-gray-400">Created Date</th>
        <th class="w-32 p-1 truncate border border-gray-400">Updated Date</th>
        <th class="w-24 p-1 truncate border border-gray-400"></th>
      </thead>
      <tbody class="">
        <tr v-for="user in laravelData.data" :key="user.id">
          <td class="p-1 text-blue-500 underline truncate border border-gray-400 w-28">
            <router-link :to="{ name: 'UserEdit',params:{ id: user.id } }">{{ user.name }}</router-link>
          </td>
          <td class="p-1 truncate border border-gray-400 w-44">{{ user.email }}</td>
          <td class="p-1 truncate border border-gray-400 w-28">{{ user.created_user.name }}</td>
          <td class="p-1 truncate border border-gray-400 w-28">{{ user.phone }}</td>
          <td class="p-1 truncate border border-gray-400 w-28">{{ user.dob }}</td>
          <td class="p-1 truncate border border-gray-400 w-44">{{ user.address }}</td>
          <td class="w-32 p-1 truncate border border-gray-400">{{ user.createtime }}</td>
          <td class="w-32 p-1 truncate border border-gray-400">{{ user.updatetime }}</td>
          <td class="w-24 p-1 truncate border border-gray-400">
            <div class="text-blue-500 underline cursor-pointer" @click="(deleteModal=true,deleteId=user.id)">Delete</div>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="mt-5">
      <advanced-laravel-vue-paginate :data="laravelData" :previousText="'<<'" :nextText="'>>'" @paginateTo="searchUser" />
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import AdvancedLaravelVuePaginate from "advanced-laravel-vue-paginate";
import "advanced-laravel-vue-paginate/dist/advanced-laravel-vue-paginate.css";
import PopUp from "./common/PopUp.vue";
export default {
  data() {
    return {
      name: "",
      email: "",
      from: "",
      to: "",
      deleteId:"",
      deleteModal:false
    };
  },
  components: {
    AdvancedLaravelVuePaginate,
    PopUp
  },
  computed: {
    ...mapState({
      laravelData: (state) => state.user.userLists,
    }),
  },
  beforeMount() {
    this.searchUser();
  },
  methods: {
    /**
     * Search and pagination user lists
     * @param int page
     * @return void
     */
    async searchUser(page = 1) {
      const parameter = {
        page: page,
        name: this.name,
        email: this.email,
        from: this.from,
        to: this.to,
      };
      await this.$store.dispatch("user/searchUser", parameter);
    },

    /**
     * Delete user
     * @return void
     */
    async deleteUser() {
      this.deleteModal = false;
      await this.$store.dispatch("user/deleteUser",this.deleteId);
      await this.searchUser();
      return;
    },
  },
};
</script>

<style>
</style>