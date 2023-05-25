<script>
import VueSelect from '@/Snippets/vueselect.mjs';

export default ({
  components: {
    VueSelect
  },
  props: {
    classname: String,
    options: {
      type: [Array, Object],
      default() {
        return []
      },
    },
    placeholder: {
      type: String,
      default: 'Select Option'
    },
    multiple: {
      type: Boolean,
      default: false
    },
    label: {
      type: String,
      default: 'label'
    },
    store: {
      type: String,
      default: 'id'
    },
    disable: {
      type: Boolean,
      default:false
    },
    modelValue: [String, Object,Number],
  },
  data() {
    return {
      selectedOption: null
    }
  },
  created() {
    if (this.modelValue !== null) {
      if (typeof this.modelValue === 'object' || typeof this.modelValue === 'string' || typeof this.modelValue === 'number') {
        this.selectedOption = this.getDatafilter(this.modelValue);
        this.$emit('update:modelValue', typeof this.modelValue === 'object' ? this.modelValue[this.store] : this.modelValue);
      }
    }
  },
  methods: {
    changeSelect(option) {
        if (this.multiple) {
          console.log(...option);
          this.$emit('update:modelValue', option)
        } else {
          this.$emit('update:modelValue', option ? option[this.store] : option);
        }
    },
    getOptionlabel(option) {
      if (typeof option === 'object') {
        if (!option.hasOwnProperty(this.label)) {
            console.warn(
                `[anngmruf-select warn]: Label key "option.${this.label}" does not` +
                ` exist in options object ${JSON.stringify(option)}.\n` +
                `check your property data.`
            )
        }
        return option[this.label]
      }
      return option
    },

    getDatafilter(option) {
      let temp = option[this.store] ?? option
      if(this.multiple){
        const data = this.options.filter((el) => {
            return temp.some((f) => {
              return f[this.store] === el[this.store];
            });
        });
       return data;
      }
      let data = this.options.find((item) => item[this.store] == temp);
      return data[this.label];
    },

  }
})
</script>

<template>
  <VueSelect :multiple="multiple" :class="classname" v-model="selectedOption" :options="options" @update:modelValue="changeSelect" :label="label" :placeholder="placeholder" :disabled="disable"/>
</template>

<style>
@import "vue-select/dist/vue-select.css";

</style>
