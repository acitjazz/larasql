
import { ref,toRaw } from 'vue';
export  function useBuildQuery(endpoint,queryString){

     const query = ref('');
     let parameters = toRaw(queryString);
     var qs = "";
     for (var key in parameters) {
     var value = parameters[key];
     if (value) {
        qs += encodeURIComponent(key) + "=" + value + "&";
     }
     }
     if (qs.length > 0) {
     qs = qs.substring(0, qs.length - 1);
     query.value = endpoint + "?" + qs;
     }

     return query
}
