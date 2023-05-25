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
          { title: 'Self', value:'self' },
          { title: 'Redirect', value:'redirect' },
          { title: 'Popup', value:'popup' },
        ],
        styles: [
          { title: 'Primary', value:'primary' },
          { title: 'Outline', value:'outline' },
        ]
    };
  },
  created() {
    this.rows = this.modelValue.length == 0 ?  [{ title: null, url: null, style: null, type: null }] : this.modelValue;
  },
  methods:{
    addRow(){
        this.$refs.tree.add({ title: null, url: null, style: null, type: null });
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
        <div class="flex w-full mb-2 max-h-[55px]">
            <a @click="removeRow(stat)" class="block text-center py-3 px-3 justify-center">
                <i class="fas text-grey-400 mr-2 text-sm fa-vector-square cursor-move"></i>
            </a>
            <div class="flex w-full mr-4">
                <input type="text" class="w-full m-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Title" v-model="node.title"
                    @change="save" />

                <input type="text" class="w-full m-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Url" v-model="node.url"
                    @change="save" />
                <InputSelect classname="inputButtonSelect w-full m-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block"
                  placeholder="Type Button" v-model="node.type" :options="types" label="title" store="value"/>

                <InputSelect classname="inputButtonSelect w-full m-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block"
                  placeholder="Style Button" v-model="node.style" :options="styles" label="title" store="value"/>
            </div>

            <a @click="removeRow(stat)" class="block text-center py-3 px-3 justify-center">
                <i class="fas text-red-400 mr-2 text-sm fa-trash"></i>
            </a>
        </div>
      </template>
    </Draggable>
    <SecondaryButton @click="addRow" v-show="this.rows.length != 2" type="button" class="justify-center "> <i class="fas text-white-400 mr-2 text-sm fa-plus"></i> Add Button</SecondaryButton>
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
