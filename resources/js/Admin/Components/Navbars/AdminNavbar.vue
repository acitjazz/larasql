<template>
  <!-- Navbar -->
  <nav
    class=" top-0 left-0 bg-white h-[64px] w-full md:flex-row md:flex-nowrap md:justify-start flex items-center p-4 shadow-md relative z-10"
  >
    <div
      class="w-full  md:px-2 px-4"
    >
      <!-- Brand -->
      <a
        class="text-sm capitalize  lg:inline-block font-semibold"
        href="javascript:void(0)"
      >
        {{$page.props.title ?? 'Dashboard'}}
      </a>
    </div>
  </nav>
  <nav
    class="top-20 left-0 w-full md:flex-row md:flex-nowrap md:justify-start flex items-center p-4 pb-0"
    v-if="$page.props.breadcumb">
    <div
      class="w-full mx-autp items-center flex  md:flex-nowrap flex-wrap md:px-4 px-4 "
    >
      <!-- Brand -->
      <div  v-for="(data,index) in $page.props.breadcumb" :key="index">
        <a class="text-sm lg:inline-block opacity-50 hover:opacity-100" :href="data.url">
        {{data.text}}
        </a>
        <span v-if="index != Object.keys($page.props.breadcumb).length - 1" class="text-sm  hidden lg:inline-block px-2 opacity-50"> /</span>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
</template>

<script>
import UserDropdown from "@/Admin/Components/Dropdowns/UserDropdown.vue";

export default {
  props:['auth'],
  components: {
    UserDropdown,
  },
  created() {
  },
};
</script>
