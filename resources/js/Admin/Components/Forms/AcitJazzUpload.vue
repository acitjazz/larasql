<script setup>
import { useDropzone } from "vue3-dropzone";
import { usePage} from '@inertiajs/inertia-vue3';
import { ref} from 'vue';
import axios from "axios";

const props = defineProps(['modelValue','folder','title','endpoint']);

const emit = defineEmits(['update:modelValue','uploaded']);

const input = ref(null);
let resfiles = ref([]);

resfiles.value = props.modelValue ?  (props.modelValue.length == 0 ?  [] : JSON.parse(props.modelValue)) : [];

const saveFile = (files) => {
    const formData = new FormData();
    formData.append('_token',  usePage().props.value.csrf_token);
    formData.append('name', props.title);
    formData.append('folder', props.folder);
    for (var x = 0; x < files.length; x++) {
    formData.append("file[]", files[x]);
    }
    axios({
        method: 'POST',
        url: props.endpoint ??  route('media.store'),
        data: formData,
        headers: {
            'Content-Type': 'multipart/form-data'
        },
        onprocessfileprogress: (e) => {
          console.log(e.lengthComputable, e.loaded, e.total)
        }
    }).then(response => {
        resfiles.value = response.data.data;
        emit('update:modelValue',JSON.stringify(resfiles.value));
        emit('uploaded',resfiles.value);
    }).catch((thrown) => {
        if (axios.isCancel(thrown)) {
            console.log('Request canceled', thrown.message)
        } else {
            // handle error
        }
    })
}
const onDrop = (acceptFiles, rejectReasons) => {
      saveFile(acceptFiles);
      console.log(rejectReasons);
}

const remove = (file) => {
    const formData = new FormData();
    formData.append('_token',  usePage().props.value.csrf_token);
    axios({
        method: 'POST',
        url:  route('media.forceDelete',{media: file.id}),
        data: formData,
    }).then(response => {
        resfiles.value = resfiles.value.filter(f => f.id != file.id);
        emit('update:modelValue',resfiles.value);
        emit('uploaded',resfiles.value);
    }).catch((thrown) => {
            console.log('Request canceled', thrown)
    })
}


const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop });

</script>

<template>
    <div>
        <div v-if="resfiles.length > 0" v-for="(file,i) in resfiles" :key="i">
            <span class="block text-xs px-2 py-1 border relative">
                {{ file.filename }}
                <i @click="remove(file)" class="fa fa-xmark -right-2 -top-2 cursor-pointer absolute w-4 h-4 bg-primary text-white rounded-full !flex items-center justify-center"></i>
            </span>
        </div>
        <div v-else v-bind="getRootProps()">
            <input v-bind="getInputProps()" />
            <div class="text-center border py-3 px-2 cursor-pointer">
                <svg class="w-7 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                    <path class="fill-primary" d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128H144zm79-217c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V392c0 13.3 10.7 24 24 24s24-10.7 24-24V257.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0l-80 80z"/>
                </svg>
               <span class="text-xs"> Drag & Drop your files</span>
            </div>
        </div>
   </div>
</template>
