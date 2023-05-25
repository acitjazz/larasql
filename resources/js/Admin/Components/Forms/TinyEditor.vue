<template>
    <div>
       <editor  :name="name" :id="name" v-model="content" :initial-value="content"
         api-key="gthcrgn3ztfz5tquigz2cnbedj4zly7drpiz2cfi8v75ircb"
         :init="editorSettings"
       />

       <popup-crop ref="popupCrop" @callback="callbackCrop"></popup-crop>
    </div>
  </template>
  <script>
  import Editor from '@tinymce/tinymce-vue'
  import PopupCrop from "@/Admin/Components/Popups/PopupCrop.vue";
  export default {
    components: {
        "editor":Editor,
        PopupCrop
    },
    props:['modelValue','name','placeholder'],
    data () {
      return {
        editorSettings: {
           height: 500,
           menubar: true,
           plugins: [ "image", "code", "table", "link", "media","lists",'wordcount','autolink'],
           toolbar:
             'undo redo | formatselect | bold italic backcolor | \
             alignleft aligncenter alignright alignjustify | link image  |  \
             bullist numlist outdent indent | removeformat | table tabledelete | \
             tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow |\
             tableinsertcolbefore tableinsertcolafter tabledeletecol ',
              automatic_uploads: true,
              images_upload_url:this.$page.props.env.upload_url,
              file_picker_types: 'file image media',
              images_upload_handler: this.handleImage,
              images_file_types: 'jpg,png,gif,webp,pdf,PDF,pptx,ppt,doc,docx',
              file_picker_callback: this.pickerCallback,
             // image_dimensions:false,

         },
        fileblob:null,
        content:'',
      }
    },
    created() {
        this.content = this.modelValue;
    },
    watch: {
      content(data) {
            this.$emit('update:modelValue',data);
      },
    },
    methods: {
      update(data) {
        this.content = data;
      },
      pickerCallback(cb, value, meta){
            var app = this;
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function () {
            var file = this.files[0];
            var reader = new FileReader();

            reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);

                cb(blobInfo.blobUri(), { title: file.name,width:100, height:100 });
                 app.$refs.popupCrop.show(blobInfo.blobUri());
            };
            reader.readAsDataURL(file);
            };

            input.click();

      },
      callbackCrop(blob){
        this.fileblob = blob;
      },
      handleImage(blobInfo, success, failure, progress) {
          xhr = new XMLHttpRequest();
          xhr.withCredentials = false;
          xhr.open('POST', this.$page.props.env.upload_url);
          xhr.upload.onprogress = function (e) {
              progress(e.loaded / e.total * 100);
          };
          xhr.onload = function() {
              var json;
              if (xhr.status === 403) {
              failure('HTTP Error: ' + xhr.status, { remove: true });
              return;
              }
              if (xhr.status < 200 || xhr.status >= 300) {
              failure('HTTP Error: ' + xhr.status);
              return;
              }
              json = JSON.parse(xhr.responseText);
              if (!json || typeof json.url != 'string') {
              failure('Invalid JSON: ' + xhr.responseText);
              return;
              }
              success(json.url);
          };

          xhr.onerror = function () {
              failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
          };
          formData = new FormData();
        //  formData.append("_token", token);
          formData.append('folder','media'); var xhr, formData;
          formData.append('file', this.fileblob, blobInfo.filename());

          xhr.send(formData);
      },
    }
  }
  </script>
