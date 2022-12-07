<template>
  <div class="w-2/6 mx-auto mt-20 loginform">
    <LogForm v-if="!loading"/>
    <div v-if="loading" class="absolute top-0 left-0 right-0 flex items-center justify-center h-screen">
      <load-spin/>
    </div>
  </div>
</template>
<script>
import LogForm from '@/components/LogForm.vue';
import LoadSpin from '@/components/common/LoadSpin.vue';
import { mapState } from 'vuex';
  export default {
    computed:{
      ...mapState({
        loading:(state) => state.isLoading
      })
    },
    components:{
      LogForm,
      LoadSpin
    },
   
  }
</script>
<style></style>