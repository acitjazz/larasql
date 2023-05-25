<template>
    <div>
        <div v-if="showpopup" class="popup-container">
        <div class="popup-overlay">
            <div class="popup-content">
                <div class="popup-header">
                    <a class="closePopup" @click="showpopup = !showpopup"><i class="fas fa-xmark"></i></a>
                </div>
                <div class="popup-body">
                    <cropper ref="cropperImage" :canvas="true" :src="file" />
                </div>
                <div class="popup-footer">
                    <a @click="save" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 w-full block text-center py-3 px-3 justify-center rounded-none rounded-b-md cursor-pointer">Save</a>
                </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
import { Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';
	export default {
        props:['placeholder'],
        components: {  Cropper },
		data () {
			return {
            upload_url:this.$page.props.env.upload_url,
            result :false,
            loader:false,
            success:true,
            showpopup:false,
            endpoint:null,
            file:null,
            error:null,
			}
		},
		created(){
		},
		methods: {
            save(){
                const { canvas } =   this.$refs.cropperImage.getResult();
                this.result = canvas;
                    if (canvas) {
                        canvas.toBlob(blob => {

                        this.$emit('callback',blob)
                        this.showpopup = false;
                        
                    });
                }
            },
            show(file){
                this.file =file;
                this.showpopup = true;
            }
		}
	};
</script>

<style scoped lang="scss">
.popup-overlay{
   position: fixed;
   left: 0; top :0;
   width: 100%; height: 100%;
   background-color: rgba(0,0,0,0.7);
   display: flex;
   justify-content: center;
   align-items: center;
   z-index: 9000;
}
.popup-header{
   position: relative;
   text-align: center;
}
.closePopup{
    cursor: pointer;
    display: block;
    width: 35px;
    height: 35px;
    background-size: 15px;
    border-radius: 100px;
    position: absolute;
    right:-15px;
    top: -20px;
    font-size: 18px;
    background: #c00;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 900;
}
.closePopup:hover{
   background-color: #c00;
}
.popup-content{
   width:90%;
   max-width:800px;
   background-color: #fff;
   margin:auto;
   border-radius: 10px;
}
.popup-body{
   h2{
      font-size: 18px;
      margin:0 0 40px 0;
   }
}
.popup-footer{
    .btn-primary{
        border-radius: 0;
    }
}
</style>