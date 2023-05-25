
<template>
    <footer class="pt-10 border-t border-darkgrey-700">
        <Container>
            <div class="flex flex-wrap -mx-3">
                <div class="mb-10 w-full md:w-3/12 mx-3">

                </div>
            </div>
        </Container>
        <Container class="border-t border-darykgrey-400">
            <p class="text-sm">© {{new Date().getFullYear()}} . All rights reserved.</p>
        </Container>
    </footer>
</template>
<script>
import IconFacebook from '@/Frontend/Components/Icons/IconFacebook.vue';
import IconTwitter from '@/Frontend/Components/Icons/IconTwitter.vue';
import IconInstagram from '@/Frontend/Components/Icons/IconInstagram.vue';
export default {
    components:{
        IconFacebook,IconInstagram,IconTwitter
    },
    props:['title'],
    data () {
        return {
            app_url:this.$page.props.env.app_url,
            showContact:false,
            page: {},
        }
    },
    methods:{
    },
};
</script>
