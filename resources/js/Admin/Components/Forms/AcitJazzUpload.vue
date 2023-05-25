<template>
    <file-pond
      name="file"
      ref="pond"
      :label-idle="idleText"
      :allow-multiple="limit == 1 ? false : true"
      :max-files="limit"
      :accepted-file-types="filetype"
      :server="server"
      :files="myFiles"
      credits="false"
      @removefile="removefile({revert: true})"
      @updatefiles="updatefiles($event)"

    />
 </template>

  <script setup>
  import vueFilePond from "vue-filepond";
  import "filepond/dist/filepond.min.css";
  import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
  import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';
  import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
  import FilePondPluginImagePreview from "filepond-plugin-image-preview";
  import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
  import { ref } from "vue";
  import { usePage} from '@inertiajs/inertia-vue3';

  const emit = defineEmits(['update:modelValue','uploaded']);
  const props = defineProps(['modelValue','source','title','folder','filetype','placeholder','limit']);
  const pond = ref(null)
  // Create component
  const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginFilePoster
  );
 const idleText = ref(`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128H144zm79-217c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V392c0 13.3 10.7 24 24 24s24-10.7 24-24V257.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0l-80 80z"/></svg> Drag & Drop your files or <span class="filepond--label-action"> Browse </span>`)
 const server = ref({
                    url:usePage().props.value.env.app_url,
                    revert:null,
                    restore: null,
                    fetch: null,
                    process: function(fieldName, file, metadata, load, error, progress, abort){
                        const formData = new FormData();
                        formData.append('_token',  usePage().props.value.csrf_token);
                        formData.append('name', props.title);
                        formData.append('folder', props.folder);
                        formData.append('file', file);
                        axios({
                            method: 'POST',
                            url: '/backend/media',
                            data: formData,
                            onprocessfileprogress: (e) => {
                                progress(e.lengthComputable, e.loaded, e.total)
                            }
                        }).then(response => {
                            resfiles.value.push(response.data.data)
                            emit('update:modelValue',resfiles.value);
                            emit('uploaded',resfiles.value);
                            load(response.data.data)
                        }).catch((thrown) => {
                            if (axios.isCancel(thrown)) {
                                console.log('Request canceled', thrown.message)
                            } else {
                                // handle error
                            }
                        })
                    },
                    load(uniqueField , load ,error){
                    }
                });
   const myFiles = ref([])
   const resfiles = ref([])
   myFiles.value  = props.modelValue?.map( (file) => {
                        return {
                            media:file,
                            source: usePage().props.value.env.app_url+'/storage/uploads/'+file.url,
                            options: {
                                type: 'local',
                                file: {
                                    id: file.id,
                                    name: file.name,
                                    url: '/storage/uploads/'+file.url,
                                    size: file.size,
                                },
                                metadata: {
                                    poster: '/storage/uploads/'+file.url,
                                }
                            }
                        }
                    });
    const removefile = (response) => {
      //  console.log('response',response)
    }
    const updatefiles = (fieldName, file, metadata, load, error, progress, abort) => {
        let files = pond.value.getFiles().map(f => f.file.id);
    }
  </script>


<style lang="scss">
.filepond--drop-label svg{
    height: 24px;
    margin: 0 auto;
    fill: #31A6DA;
}
.filepond--drop-label{
    font-size: 12px !important;
    padding: 10px  0!important;
}
</style>
