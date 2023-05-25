
import { ref } from 'vue'

export default function mediaquery(){

   const mediaquery = ref(1400);
   const isServer = typeof window === 'undefined'

   if (! isServer) {
      const resizeWidow = (e) => {
            
           mediaquery.value = window.innerWidth;
      }
   
      resizeWidow();
      window.addEventListener("resize", resizeWidow());
   }

   return mediaquery.value;
}