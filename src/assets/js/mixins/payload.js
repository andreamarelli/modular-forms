export default {

    /**
     * Encode JSON object to Base64
     * @param obj
     * @returns {string}
     */
    encode(obj){
        return btoa(JSON.stringify(obj));
    },

    /**
     * Decode JSON object from Base64
     *
     * @param encoded_obj
     * @returns {any}
     */
    decode(encoded_obj){
        return JSON.parse(atob(encoded_obj));
    }

};