<script>
import "@he-tree/vue/style/default.css";
import AcitJazzUpload from '@/Admin/Components/Forms/AcitJazzUpload.vue';
import SecondaryButton from '@/Admin/Components/Buttons/SecondaryButton.vue';
import InputButtons from '@/Admin/Components/Forms/InputButtons.vue';
import { reactive, defineComponent, onMounted } from "vue";
export default defineComponent({
  props:['modelValue'],
  components: {  AcitJazzUpload, SecondaryButton, InputButtons },
  data() {
    return {
        rows :null,
        banners:null,
        default : [{ title: null, subtitle: null, summary: null, desktop: null, mobile: null, buttons: []}],
    };
  },
  created() {
    this.rows = this.modelValue ?  (this.modelValue.length == 0 ?  this.default : this.modelValue) : this.default;
  },

  methods:{
    addRow(){
        this.$refs.tree.add({ title: null, subtitle: null, summary: null, desktop: null, mobile: null, buttons: [] });
        this.save();
    },
    removeRow(stat){
      console.log(this.rows[stat])
        if(this.rows.length > 1){
          this.$refs.tree.remove(stat);
        }
        this.save();
    },
    save(){
        this.banners = this.$refs.tree.getData().filter(function( obj ) {
            return obj.title != null;
        });
        this.$emit('update:modelValue', this.banners);
    },
    uploaded(stat){
        this.save();
    }
  },
});
</script>

<template>
  <div>
    <Draggable v-model="rows" ref="tree" virtualization
        :maxLevel="1"
        :watermark="false">
      <template #default="{ node, stat }">
        <span v-if="stat.children.length" @click="stat.open = !stat.open">
          {{ stat.open ? "-" : "+" }}
        </span>
        <div class="w-full mb-5">
          <div class="flex w-full">
            <a @click="removeRow(stat)" class="block text-center py-3 px-3 justify-center">
                <i class="fas text-grey-400 mr-2 text-sm fa-vector-square cursor-move"></i>
            </a>
            <div class="flex-initial w-full mr-4">
                <input type="text" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Title" v-model="node.title"
                    @change="save" />
                <TextAreaInput id="summary" class="w-full  border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Summary" v-model="node.summary" @change="save"/>
                <div class="flex w-full gap-1.5 mb-4">
                    <div class="w-full">
                      <label for="desktop" class="text-blueGray-700 hover:text-blueGray-500 text-sm py-3 font-bold block">Desktop banner</label>
                        <acit-jazz-upload
                        class="mt-1 block w-full"
                        :title="`${node.title}-desktop`"
                        folder="banners"
                        name="desktop"
                        :limit="1"
                        filetype="image/*"
                        v-model="node.desktop"
                        @uploaded="uploaded(stat)"
                        >
                        </acit-jazz-upload>
                    </div>
                    <div class="w-full">
                      <label for="mobile" class="text-blueGray-700 hover:text-blueGray-500 text-sm py-3 font-bold block">Mobile banner</label>
                        <acit-jazz-upload
                        class="mt-1 block w-full"
                        :title="`${node.title}-mobile`"
                        folder="banners"
                        name="mobile"
                        :limit="1"
                        filetype="image/*"
                        v-model="node.mobile"
                        @uploaded="uploaded(stat)"
                        >
                        </acit-jazz-upload>
                    </div>
                </div>

            </div>
            <a @click="removeRow(stat)" class="block text-center py-3 px-3 justify-center">
                <i class="fas text-red-400 mr-2 text-sm fa-trash"></i>
            </a>
          </div>
          <div class="w-full mt-2 px-5">
            <InputButtons v-model="node.buttons"/>
          </div>
        </div>
      </template>
    </Draggable>
    <SecondaryButton @click="addRow" type="button" class="justify-center "> <i class="fas text-white-400 mr-2 text-sm fa-plus"></i> Add New Banner</SecondaryButton>
  </div>
</template>
<style>
.vtlist.he-tree {
  overflow:unset !important;
}
</style>
