<template>
  <div class="absolute top-0 left-0 z-10 w-full h-full text-center bg-black bg-opacity-10">
    <div class="z-20 inline-block w-1/4 p-5 mt-20 text-left bg-white rounded-md shadow-2xl">
      <div class="flex justify-between pb-2 font-bold border-gray-300 boder-b-2">
        <div class="">
          {{title}}
        </div>
        <div @click="clickClose" class="text-lg text-black cursor-pointer">
          &#x2716;
        </div>
      </div>
      <div class="py-2 text-md">
        {{ text }}
      </div>
      <div class="flex justify-end space-x-5">
        <button @click="clickClose" class="px-2 py-0.5 border border-black rounded-sm">Cancel</button>
        <button @click="clickConfirm" class="px-2 py-1 text-white bg-blue-500 rounded-sm">Confirm</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props:['title','text'],
  methods:{

    /**
     * Emit close event to parent component
     * @return void
     */
    clickClose() {
      this.$emit('closebox');
    },

    /**
     * Emit confirm event to parent component
     * @return void
     */
    clickConfirm() {
      this.$emit('confirmbox');
    },
  }
}
</script>

<style>

</style>