<script>
import "@he-tree/vue/style/default.css";
import SecondaryButton from '@/Admin/Components/Buttons/SecondaryButton.vue';
import InputSelect from '@/Admin/Components/Forms/InputSelect.vue';
import { reactive, defineComponent, onMounted } from "vue";
import VueSelect from "vue-select";

export default defineComponent({
  props:['modelValue'],
  components: {  SecondaryButton, InputSelect, VueSelect },
  data() {
    return {
        rows: null,
        buttons: null,
        showButton: true,
        types: [
          // { title: 'Banner', value:'Banner' },
          { title: 'Product Section', value:'ProductSection' },
          { title: 'Cara Kerja Kami', value:'HowSection' },
          { title: 'Skema Harga', value:'PriceSchemaSection' },
          { title: 'CTA Section', value:'CtaSection' },
          { title: 'News Section', value:'NewsSection' },
          { title: 'Partner Section', value:'PartnerSection' },
          { title: 'Testimoni Section', value:'TestimoniSection' },
          { title: 'Video Section', value:'VideoSection' },
          { title: 'Gudang Section', value:'GudangSection' },
        ],
    };
  },
  created() {
    this.rows = this.modelValue ??  [{ title: null, summary:null, code: null, type: null }];
  },
  methods:{
    addRow(){
        this.$refs.tree.add({ title: null, summary:null, code: null, type: null });
        this.save();
    },
    removeRow(stat){
        if(this.rows.length > 0){
          this.$refs.tree.remove(stat);
        }
        this.save();
    },
    save(){
        this.buttons = this.$refs.tree.getData().filter(function( obj ) {
            return obj.title != null;
        });
        this.$emit('update:modelValue', this.buttons);
    },
    uploaded(stat){
        this.save();
    }
  },
});
</script>

<template>
  <div @mouseleave="save" id="input-buttons">
    <Draggable v-model="rows" ref="tree" virtualization
        :maxLevel="1"
        :watermark="false">
      <template #default="{ node, stat }">
        <span v-if="stat.children.length" @click="stat.open = !stat.open">
          {{ stat.open ? "-" : "+" }}
        </span>
        <div class="flex w-full mb-2">
            <a  class="block text-center py-3 px-3 justify-center">
                <i class="fas text-grey-400 mr-2 text-sm fa-vector-square cursor-move"></i>
            </a>
            <div class="flex w-full mr-4">
                <div class="w-full m-2">
                  <input type="text" class="w-full mb-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Title" v-model="node.title"
                      @change="save" />

                  <textarea  class="w-full mb-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Summary" v-model="node.summary"
                  @change="save"></textarea>

                  <input v-show="node.type == 'VideoSection'" type="text" class="w-full  border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Code YouTube" v-model="node.code"
                      @change="save" />

                </div>
                <div class="w-full m-2">
                    <InputSelect classname="inputButtonSelect border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block"
  placeholder="Section" v-model="node.type" :options="types" label="title" store="value"/>

                </div>
            </div>

            <a @click="removeRow(stat)" class="block text-center py-3 px-3 justify-center">
                <i class="fas text-red-400 mr-2 text-sm fa-trash"></i>
            </a>
        </div>
      </template>
    </Draggable>
    <SecondaryButton @click="addRow" type="button" class="justify-center "> <i class="fas text-white-400 mr-2 text-sm fa-plus"></i> Add Section</SecondaryButton>
  </div>
</template>
<style lang="scss">
#input-buttons {
  .vtlist.he-tree {
    overflow:unset !important;
  }
  .inputButtonSelect .vs__dropdown-toggle {
    height: 100%;
  }
}

</style>
