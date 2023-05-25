<template>
    <div>

    <div  class="flex gap-2" :class="{'hidden':!strfile}">
        <div class="p-2 text-sm w-fit bg-gray-100 rounded px-3" v-for="(s,a) in strfile">
            {{ s }}
        </div>
        <div class="p-2 text-sm w-fit bg-primary text-white rounded px-3 cursor-pointer" @click="resetFile">
            Remove
        </div>
    </div>
    <div class="ac-component" :class="{'hidden':strfile}">
       <div class="ac-upload-container">
        <input type="file" ref="filePond" name="file"  />
       </div>
       <div class="ac-slot">
         <slot></slot>
       </div>
    </div>
    </div>
</template>


<script>
import * as FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';

FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageExifOrientation,
    FilePondPluginFileValidateType);
export default {
    props:['title','folder','modelValue','placeholder','settings','name','filetype','endpoint'],
    data () {
        return {
            options:{
                server:{
                    url: '/',
                    timeout: 10000,
                    process: {
                        url: this.endpoint,
                        method: 'POST',
                        headers: {
                            'Accept' : 'application/json',
                        },
                        withCredentials: false,
                        onload: (response) => {
                            this.addFiles(response);
                            return response;
                        },
                        onerror: (response) => response.data,
                        ondata: (formData) => {

                            formData.append('_token',  this.$page.props.csrf_token);
                            formData.append('name', this.title);
                            formData.append('folder', this.folder);

                            return formData;
                        }
                    },
                    revert: './backend/media/destroy',
                    restore: './storage/restore/',
                    load: './',
                    fetch: './storage/fetch/',
                },
                maxFiles: 10,
                allowMultiple:true,
                allowReorder:true,
                required: false,
                credits:false,
                labelIdle:'Browse',
                files:[],
            },
            resfile:null,
            files:[],
            filedata:null,
            strfile:null
        }
    },
    created(){
        this.resfile =this.modelValue ? JSON.parse(this.modelValue) : '';
        this.options.labelIdle = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128H144zm79-217c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V392c0 13.3 10.7 24 24 24s24-10.7 24-24V257.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0l-80 80z"/></svg>' + (this.placeholder ?? 'Drag & Drop your files or <span class="filepond--label-action"> Browse </span>')
        this.mapFiles(this.resfile)
    },
    methods:{
        addFiles(newfile){
            this.files.push(JSON.parse(newfile));
            this.resfile = this.files;
            this.strfile  = this.files.map( (file) => {
                return file.data.uuid;
            });
            console.log(this.files)
            this.$emit('update:modelValue', this.strfile.toString());
            this.$emit('uploaded', this.strfile.toString());
            this.mapFiles(this.resfile)
        },
        mapFiles(files){
            try{
                let extensions =['jpg','jpeg','gif','png','webp'];
                var filedata  = files.map( (file) => {
                    return {
                        media:file,
                        source :  'storage/uploads/'+file.url,
                        options: {
                            type: 'local',
                            metadata: {
                                id: file.id,
                                name: file.name,
                                url: file.url,
                                size: file.size,
                            },
                        }
                    }
                });
                this.options.files = filedata;
            }catch(e){
                this.options.files = [];
            }
        },
        removeFile(file){
            axios.delete('/backend/media/destroy', { data: file})
            .then( (response) => {
                 this.resfile = this.options.files;
                this.$emit('update:modelValue',this.resfile);
            });
        },
        resetFile(){
            this.strfile = null;
            this.$emit('update:modelValue', '');
            this.$emit('uploaded', '');
        }
    },
    mounted(){
            const inputElement = this.$refs.filePond;
            this.pond = FilePond.create(inputElement,{
                acceptedFileTypes: this.filetype ?? ['image/*','video/*','application/*'],
            });
            const options = {...this.options, ...this.settings};
            this.pond.setOptions(this.options);
            this.pond.on('removefile', (error, file) => {
                var fx = this.options.files.findIndex(f => file.source == f.source);
                var fi = this.options.files[fx];
                this.options.files.splice(fx,1);
                //this.removeFile(fi.media)
            });
    }
};
</script>

<style lang="scss">
.filepond--credits{
    display: none;
}
.filepond--drop-label.filepond--drop-label label{
    cursor: pointer;
    font-size: 12px;
}
.filepond--drop-label.filepond--drop-label label i{
    font-size: 20px;
}
.filepond--root{
    margin: 0;
}
.filepond--root,
.filepond--root .filepond--drop-label {
  height: 90px;
}
.filepond--drop-label svg{
    height: 24px;
    margin: 0 auto;
    fill: #31A6DA;
}
</style>
