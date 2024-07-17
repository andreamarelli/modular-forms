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

    pretty_number(value, precision = 0){
        value = Number(parseFloat(value).toFixed(precision));
        return isNaN(value)
            ? '-'
            : value.toLocaleString('fr-FR');  // french notation
    }

}
