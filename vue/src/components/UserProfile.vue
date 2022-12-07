<template>
  <div class="mt-20 ml-48">
    <div class="flex items-center mb-10 space-x-96">
      <h2 class="text-xl font-bold">User Profile</h2>
      <div class="text-blue-600 underline">
        <router-link :to="{name: 'UserEdit',params:{id:getUserID}}">Edit</router-link>
      </div>
    </div>
    <div class="flex flex-col mx-auto text-left space-y-7">
      <div class="flex space-x-52">
        <div class="font-bold w-44">Name</div>
        <div class="flex flex-col justify-start">
          <div>{{ name }}</div>
          <div class="w-40 h-40">
            <img v-if="profile" class="w-full h-full rounded-md" :src="profile" />
          </div>
        </div>
      </div>
      <div class="flex space-x-52">
        <div class="font-bold w-44">Email Address</div>
        <div class="flex flex-col justify-start">
          {{ email }}
        </div>
      </div>
      <div class="flex space-x-52">
        <div class="font-bold w-44">Type</div>
        <div class="flex flex-col justify-start">
          {{ type }}
        </div>
      </div>
      <div class="flex space-x-52">
        <div class="font-bold w-44">Phone</div>
        <div class="flex flex-col justify-start">
          {{ phone }}
        </div>
      </div>
      <div class="flex space-x-52">
        <div class="font-bold w-44">Date Of Birth</div>
        <div class="flex flex-col justify-start">
          {{ dob }}
        </div>
      </div>
      <div class="flex space-x-52">
        <div class="font-bold w-44">Address</div>
        <div class="flex flex-col justify-start">
          {{ address }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      name: "Wai Thura",
      id: 0,
      profile: "",
      email: "",
      address: "",
      type: "",
      phone: "",
      dob: "",
    };
  },
  mounted() {
    this.getData();
  },
  computed: {
    ...mapState({
      getUserID: (state) => state.auth.id,
    }),
  },
  methods: {
    async getData() {
      let response = await this.$store.dispatch(
        "user/getProfile",
        this.getUserID
      );
      if (response.status === 200) {
        this.name = response.data.user.name;
        this.email = response.data.user.email;
        this.phone = response.data.user.phone;
        this.type = response.data.user.typename;
        this.address = response.data.user.address;
        this.dob = response.data.user.dob;
        this.profile = response.data.user.profile;
      }
      else {
        this.$store.commit("auth/logout");
        localStorage.clear();
        this.$router.push("/login");
      }
    },
  },
};
</script>

<style>
</style>