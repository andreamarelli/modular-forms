export default {

    isNumeric(value) {
        if(typeof value === 'string'){
            value = value.replace(' ', '');
        }
        return !(value === ''
            && value === false
            && value === null
            && isNaN(value));
    },

}
