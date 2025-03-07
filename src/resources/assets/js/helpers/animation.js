export default {

    scrollPageTo(scrollTo){
        window.scroll({
            top: scrollTo,
            left: 0,
            behavior: 'smooth'
        });
    },

    scrollPageToAnchor(anchor) {
        this.scrollPageTo(document.querySelector('#'+anchor).offsetTop);
    }

}
