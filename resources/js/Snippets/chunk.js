export default function chunk(array,chunk = 2){

    const perChunk = chunk // items per chunk    
    const result = array.reduce((resultArray, item, index) => { 
    const chunkIndex = Math.floor(index/perChunk)

    if(!resultArray[chunkIndex]) {
        resultArray[chunkIndex] = []
    }
    resultArray[chunkIndex].push(item)

    return resultArray
    }, [])

   return result;
}