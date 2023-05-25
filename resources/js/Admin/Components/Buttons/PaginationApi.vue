<template>
  <div class="flex gap-3">
    <Link class="border px-3 text-sm py-2 bg-white hover:bg-primary hover:text-white page-link" :disabled="currentPage === 1"  :class="{'disabled': currentPage <= 1}" :href="href" :data="{page: currentPage-1}">Prev</Link>
    <Link class="border px-3 text-sm py-2 bg-white hover:bg-primary hover:text-white page-link" v-for="pageNumber in visiblePages" :key="pageNumber" :class="{'active': currentPage === pageNumber}"
     :href="href" :data="{page: pageNumber}">{{ pageNumber }}</Link>
    <Link class="border px-3 text-sm py-2 bg-white hover:bg-primary hover:text-white page-link" :disabled="currentPage === totalPage" :href="href" :class="{'disabled': currentPage >= totalPage}" :data="{page: currentPage+1}">Next</Link>
  </div>
</template>

<script>
export default {
  props: {
    href: {
      type: String,
      required: true,
    },
    totalPage: {
      type: Number,
      required: true,
    },
    currentPage: {
      type: Number,
      required: true,
    },
  },
  computed: {
    visiblePages() {
      const range = 2; // number of pages to show on either side of the current page
      let start = Math.max(this.currentPage - range, 1);
      let end = Math.min(this.currentPage + range, this.totalPage);
      if (start === 1) {
        end = Math.min(end + range - start, this.totalPage);
      } else if (end === this.totalPage) {
        start = Math.max(start - (range - (this.totalPage - end)), 1);
      }
      return Array(end - start + 1)
        .fill()
        .map((_, i) => start + i);
    },
  },
  methods: {
    prevPage() {
      this.$emit('update:currentPage', this.currentPage - 1);
    },
    nextPage() {
      this.$emit('update:currentPage', this.currentPage + 1);
    },
    goToPage(pageNumber) {
        console.log(pageNumber);
      this.$emit('update:currentPage', pageNumber);
    },
  },
};
</script>

<style scoped>

.active {
    background-color:#E9001A;
    color: #fff;
}
.disabled{
    background-color: #eaeaea;
}

.disabled:hover{
    color: #000;
    background-color: #eaeaea;
}
</style>
