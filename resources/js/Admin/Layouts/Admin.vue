<template>
  <div class="min-h-screen">
    <sidebar />
    <div class="relative md:ml-64 min-h-screen flex flex-col">
      <admin-navbar  :auth="auth"/>
      <div class="mx-auto w-full">
       <slot />
      </div>
       <footer-admin class="mt-auto"/>
    </div>
  </div>
</template>
<script>
import AdminNavbar from "@/Admin/Components/Navbars/AdminNavbar.vue";
import Sidebar from "@/Admin/Components/Sidebar/Sidebar.vue";
import FooterAdmin from "@/Admin/Components/Footers/FooterAdmin.vue";
import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css"
export default {
  props:['auth'],
  name: "admin-layout",
  components: {
    AdminNavbar,
    Sidebar,
    FooterAdmin,
  },
  watch: {
    flash: {
      deep: true,
      handler(val, oldVal) {
        if(val.has_flash){
            Toastify({
                text: val.message,
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            },
                onClick: function(){} // Callback after click
            }).showToast();
        }

      },
    },
  },
  computed: {
    flash() {
      return this.$page.props.flash
    },
  },
};
</script>
