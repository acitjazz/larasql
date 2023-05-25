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
        features:null,
    };
  },
  created() {
        this.rows = this.modelValue ??  [{ title: null, image: null }];

  },

  methods:{
    addRow(){
        this.$refs.tree.add({ title: null, image: null });
        this.save();
    },
    removeRow(stat){
        if(this.rows.length > 1){
          this.$refs.tree.remove(stat);
        }
        this.save();
    },
    save(){
        this.features = this.$refs.tree.getData().filter(function( obj ) {
            return obj.image != null;
        });

        this.$emit('update:modelValue', this.features);
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
            <div class="flex-initial w-1/2 mr-4">
                <input type="text" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Title" v-model="node.title"
                    @change="save" />
                <acit-jazz-upload
                      class="mt-1 block w-full"
                      :title="node.title"
                      folder="features"
                      name="images"
                      label="Browse"
                      v-model="node.image"
                      @uploaded="uploaded(stat)"
                    >
                </acit-jazz-upload>
            </div>

            <a @click="removeRow(stat)" class="block text-center py-3 px-3 justify-center">
                <i class="fas text-red-400 mr-2 text-sm fa-trash"></i>
            </a>
          </div>
        </div>
      </template>
    </Draggable>
    <SecondaryButton @click="addRow" type="button" class="justify-center "> <i class="fas text-white-400 mr-2 text-sm fa-plus"></i> Add New Gallery </SecondaryButton>
  </div>
</template>
<style>
.vtlist.he-tree {
  overflow:unset !important;
}
</style>
