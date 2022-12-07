<template>
  <div>
    <UserProfile :userid='getID'/>
  </div>
</template>

<script>
import UserProfile from '../components/UserProfile.vue';
export default {
  computed:{
    getID() {
      return this.$store.getters["auth/getID"];
    },
  },
  components:{
    UserProfile
  }
}
</script>

<style>

</style>