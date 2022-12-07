<template>
  <div class="absolute top-0 left-0 z-10 w-full h-full text-center bg-black bg-opacity-10">
    <div class="z-20 inline-block w-1/3 p-5 mt-20 text-left bg-white rounded-md shadow-2xl">
      <div class="flex justify-between pb-2 font-bold border-gray-300 boder-b-2">
        <div class="text-lg">
          Post Detail
        </div>
        <div @click="clickClose" class="text-lg text-black cursor-pointer">
          &#x2716;
        </div>
      </div>
      <div class="flex flex-col p-5 space-y-5">
        <div class="flex items-center space-x-10">
        <div class="w-48 font-bold">Title</div>
        <div class="truncate">{{ post.title }}</div>
      </div>
      <div class="flex items-center space-x-10">
        <div class="w-48 font-bold">Description</div>
        <div class="truncate">{{ post.description }}</div>
      </div>
      <div class="flex items-center space-x-10">
        <div class="w-48 font-bold">Status</div>
        <div class="truncate">{{ post.statustext }}</div>
      </div>
      <div class="flex items-center space-x-10">
        <div class="w-48 font-bold">Created At</div>
        <div class="truncate">{{ post.posttime }}</div>
      </div>
      <div class="flex items-center space-x-10">
        <div class="w-48 font-bold">Create User</div>
        <div class="truncate">{{ post.created_user.name }}</div>
      </div>
      <div class="flex items-center space-x-10">
        <div class="w-48 font-bold">Last Updated At</div>
        <div class="truncate">{{ post.updatetime }}</div>
      </div>
      <div class="flex items-center space-x-10">
        <div class="w-48 font-bold">Update User</div>
        <div class="truncate">{{ post.updated_user.name }}</div>
      </div>
      </div>
      <div class="flex space-x-5">
        <button @click="clickClose" class="px-3 py-1 text-white bg-blue-500 rounded-sm">Dismiss</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props:['post'],
  methods:{
    clickClose() {
      this.$emit('closedetail');
    },
  }
}
</script>

<style>

</style>