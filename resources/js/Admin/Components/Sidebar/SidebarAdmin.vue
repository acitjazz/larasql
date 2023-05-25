<template>
  <nav
    class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-md bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10"
  >
    <div
      class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto"
    >
      <!-- Toggler -->
      <button
        v-bind:class="menuShow"
        class="cursor-pointer text-primary md:hidden px-3 py-1 text-2xl leading-none bg-transparent rounded border border-solid border-transparent"
        type="button"
        v-on:click="toggleCollapseShow('bg-white top-16','hidden')"
      >
        <i class="fas fa-bars"></i>
      </button>
      <button
        v-bind:class="collapseShow"
        class="cursor-pointer text-primary md:hidden px-3 py-1 text-2xl leading-none bg-transparent rounded border border-solid border-transparent"
        type="button"
        v-on:click="toggleCollapseShow('hidden','block')"
      >
        <i class="fas fa-times"></i>
      </button>
      <!-- Brand -->
      <Link
        class="md:block text-left h-[64px]  text-blueGray-600 py-2 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold  px-0"
        :href="menu.link"
      >
        <ApplicationLogo class="max-h-12 mx-auto" v-if="menu.logo"></ApplicationLogo>
        <span v-else> {{menu.title}}</span>
      </Link>
      <!-- User -->
      <ul class="md:hidden items-center flex flex-wrap list-none">
        <li class="inline-block relative">
         <a href="" class="mr-5"> <i class="fa fa-question-circle"></i></a>
        </li>
      </ul>
      <!-- Collapse -->
      <div
        class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1"
        v-bind:class="collapseShow"
      >
        <!-- Collapse header -->
        <!-- Divider -->
         <Link v-if="user.data.roles!='superadmin'" href="/ticket/create" class="bg-primary text-white flex items-center px-6 py-3 rounded-none hover:bg-black border-l-2 border-transparent hover:border-primary">Create Ticket <img class="ml-auto" src="/images/icons/icon-plus.svg" alt="Create"></Link>
        <div v-for="(section, index) in menu.sections" :key="index">
          <h6 v-if="section.title"
            class="md:min-w-full text-blueGray-500 text-sm font-semibold block py-4 px-6 no-underline"
          >
           {{section.title}}
          </h6>
            <ul class="md:flex-col md:min-w-full flex flex-col list-none" :class="section.class">
              <li class="items-center" v-for="(menu, index) in section.menus" :key="index">
                <div v-if="menu.submenu?.length > 0">
                  <span class="text-blueGray-700 hover:text-blueGray-500 text-sm py-3  block">
                    <i class="fas text-[#777] mr-2 text-sm" :class="menu.icon"></i>
                    {{menu.title}}
                  </span>
                  <ul class="md:flex-col md:min-w-full flex flex-col list-none md:mb-4 pl-4">
                    <li class="items-center" v-for="(submenu, index) in menu?.submenu" :key="index">
                      <Link
                        class="text-[#777] hover:text-blueGray-500 text-sm py-3 block"
                        :href="submenu.link"
                        :method="submenu.method"
                      >
                        <i class="fas text-[#777] mr-2 text-sm" :class="submenu.icon"></i>
                        {{submenu.title}}
                      </Link>
                    </li>
                  </ul>
                </div>
                <Link
                  v-else
                  class="text-blueGray-700 w-full text-left hover:text-blueGray-500 text-sm py-4  px-6 hover:bg-gray-100 hover:border-l-2 hover:border-primary  block"
                  :href="menu.link"
                  :method="menu.method"
                  :as="menu.as"
                  :class="{'bg-gray-100 border-l-2 border-primary': currentPath === menu.link}"
                >
                  <i class="fas text-[#777] mr-2 text-sm" :class="menu.icon"></i>
                  {{menu.title}}
                </Link>
              </li>
            </ul>
           <hr class="md:min-w-full" />
        </div>
        <Link  class="px-6 py-3 text-sm flex items-center mb-5 hover:bg-gray-100 hover:border-l-2 hover:border-primary">
            <div>
                <span class="font-semibold text-black block">{{ user.data.name }}  </span>
             
            </div>
            <i class="fas text-[#777] mr-2 text-sm fa-chevron-right ml-auto"></i>
        </Link>
       
      </div>
    </div>
  </nav>
</template>


<script>
import NotificationDropdown from "@/Admin/Components/Dropdowns/NotificationDropdown.vue";
import UserDropdown from "@/Admin/Components/Dropdowns/UserDropdown.vue";
import ApplicationLogo from "@/Admin/Components/ApplicationLogo.vue";
import { Head, Link, useForm ,usePage} from '@inertiajs/inertia-vue3';

export default {
  data() {
    return {
      collapseShow: "hidden",
      menuShow: "block",
      isActive:false,
      menu:usePage().props.value.navigation,
      user:usePage().props.value.auth.user,
        isadmin:usePage().props.value.isadmin,
      currentPath:usePage().props.value.current_path,
    };
  },
  created(){
   // this.fetchMenus();
  },
  methods: {
    toggleCollapseShow: function (classes,menu) {
      this.collapseShow = classes;
      this.menuShow = menu
    },
    fetchMenus() {

        axios.get(route('backend.menu')).then(response => {
            this.menu = response.data;;
        }).catch(error => {
            console.log(error);
        });
    },
  },
  components: {
    NotificationDropdown,
    UserDropdown,
    Link,
    ApplicationLogo,
  },
};
</script>
