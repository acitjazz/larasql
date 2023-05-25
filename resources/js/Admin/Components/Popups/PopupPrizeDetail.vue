<template>
    <div @click="close" v-if="showPopup" class="popup-wrapper fixed left-0 top-0 w-full h-full bg-[rgba(0,0,0,0.7)] z-[1000]">
    </div>
    <div @click="closeConfirm" v-if="showConfirm" class="popup-wrapper fixed left-0 top-0 w-full h-full bg-[rgba(0,0,0,0.7)] z-[1000]">
    </div>
    <div v-if="loader"  class="popup-wrapper flex justify-center items-center fixed left-0 top-0 w-full h-full bg-[rgba(0,0,0,0.7)] z-[1000]">
                <Loader></Loader>
    </div>
    <div v-if="showPopup" class="overflow-x flex flex-col w-[40vw] max-w-[500px] z-[1000] mr-auto w-full absolute bg-white top-0 right-0 h-full">
        <div class="flex w-full p-5 items-center relative bg-gray-100">
            <i @click="close" class="fa fa-chevron-left w-5  text-center cursor-pointer relative z-10"></i>
            <h2 class="text-center font-semibold absolute w-full left-0 top-0 h-full flex items-center justify-center">Detail {{ prize.type }}</h2>
        </div>
        <Link v-if="user" class="bg-amber-400 w-full block px-6 py-3 flex justify-center items-center text-[#785600] menu-point mb-15" :href="route('point.index')">
            <i class="fa fa-coins mr-3"></i>
            <span class="font-semibold">{{ user.data.point.text }}</span>
        </Link>
        <div v-if="prize"  class="p-5  ">
            <div class="w-full  overflow-hidden bg-white  p-2 mb-3 flex justify-center items-center">
                <img :src="prize.image" :alt="prize.title" class="h-28">
            </div>
            <h3 class="text-sm font-semibold mb-5">{{ prize.title }}</h3>
            <div class="bg-amber-400 uppercase font-semibold text-sm w-full block px-2 py-2 flex justify-center items-center text-[#785600] mb-5">
                {{ prize.point.text }}
            </div>
            <div class="flex text-sm mb-5">
                <strong class="font-semibold">Expired at</strong>
                <span class="ml-auto">{{ prize.expired_at }}</span>
            </div>
            <div class="flex text-sm">
                <strong class="font-semibold">Remaining {{ prize.type }}</strong>
                <span class="ml-auto">{{ prize.qty.value }}/{{ prize.init_qty.value }}</span>
            </div>
            <div class="relative h-10">
                <div class="w-full h-2 bg-[#ccc] absolute left-0 top-3 rounded-full">
                    <div class="bg-primary h-2 w-0 rounded-full relative" :style="'width:'+prize.remaining">
                        <div class="bg-primary w-4 h-4 rounded-full absolute right-0 -top-1"></div>
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <h4 class="font-semibold">Detail</h4>
                <p class="text-sm">
                    {{ prize.description }}
                </p>
            </div>
            <article class="mb-5 article">
                <h4 class="font-semibold">Terms & Condition</h4>
                <div class="text-sm" v-html="prize.tnc"></div>
            </article>
            <div class="">
                <APrimaryButton @click="confirm" as="button" type="button" preserve-state class="block w-full text-center py-3 px-3 justify-center">
                    Redeem
                </APrimaryButton>
            </div>
        </div>
    </div>
    <div v-if="showConfirm" class="overflow-x flex flex-col w-[40vw] max-w-[500px] z-[1000] mr-auto w-full absolute bg-white top-0 right-0 h-full">
        <div class="flex w-full p-5 items-center relative bg-gray-100">
            <i @click="closeConfirm" class="fa fa-chevron-left w-5  text-center cursor-pointer relative z-10"></i>
            <h2 class="text-center font-semibold absolute w-full left-0 top-0 h-full flex items-center justify-center">Redeem Confirmation</h2>
        </div>
        <div v-if="prize"  class="p-5  ">
            <div class="w-full  overflow-hidden bg-white  p-2 mb-3 flex justify-center items-center">
                <img :src="prize.image" :alt="prize.title" class="h-28">
            </div>
            <h3 class="text-sm font-semibold mb-5">{{ prize.title }}</h3>
            <div class="mb-5">
                <p class="text-sm">
                    <p>Do you want to redeem?</p>
                </p>
            </div>
            <span class="block text-white bg-primary text-center mb-5 text-sm py-2" v-if="form.errors.has('prize') && haserror" v-html="form.errors.get('prize')"></span>

            <div v-if="loader" class="flex justify-center"><Loader class="w-7"></Loader></div>
            <div class="flex gap-10" v-else>
                <OutlineButton @click="closeConfirm" as="button" type="button" preserve-state class="block w-full text-center py-3 px-3 justify-center">
                    Cancel
                </OutlineButton>
                <APrimaryButton @click="redeem" as="button" type="button" preserve-state class="block w-full text-center py-3 px-3 justify-center">
                    Ok
                </APrimaryButton>
            </div>
        </div>
    </div>
    <PopupThankYouRedeem ref="popupThankyou"></PopupThankYouRedeem>
</template>

<script setup>
    import Form from '@/Snippets/Form.js'
    import { ref,defineAsyncComponent } from 'vue'
    const PopupThankYouRedeem = defineAsyncComponent(
        () => import('@/Admin/Components/Popups/PopupThankYouRedeem.vue')
    )
    const popupThankyou = ref(null);
    const showPopup = ref(false);
    const showConfirm = ref(false);
    const haserror = ref(false);
    const loader = ref(false);
    const prize = ref({});
    const user = ref({});
    let props  = defineProps({
        status:String
    });
    const formdata = new Form(
        {
        prize_id:prize.value.id,
        }
    );
    const form = ref(formdata);
    const close = () => {
        showPopup.value = false;
    }
    const closeConfirm = () => {
        showPopup.value = false;
        showConfirm.value = false;
        haserror.value = false;
    // form.value.errors = [];
    }
    const confirm = () => {
        showPopup.value = false;
        showConfirm.value = true;
    }

    const redeem = async ()=> {
        form.value.post(route('reward.redeem',{prize:prize.value.id})).then((response) => {
            if(response.success){
                loader.value = false;
                showPopup.value = false;
                showConfirm.value = false;
                haserror.value = false;
                popupThankyou.value.firePopup()
            }
        })
        .catch((response) => {
            haserror.value = true;
        });
    }
    const firePopup = (data,datauser,detail) => {
        prize.value = data;
        user.value = datauser;
        if(detail){
            showPopup.value = true;
            showConfirm.value = false;
        }else{
            showPopup.value = false;
            showConfirm.value = true;
        }
        const isServer = typeof window === 'undefined'

        if (! isServer) {
         window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
    defineExpose({ firePopup });



</script>
