export default {

    CLASS_NAME_SHOW: 'show',

    toggle: function(evt){

        let clicked_accordion_item = evt.target.closest('.accordion-item')
        let accordion = clicked_accordion_item.closest('.accordion');
        let is_current_clicked_item_active = clicked_accordion_item.classList.contains(this.CLASS_NAME_SHOW);

        // Close all others
        let accordion_items = accordion.querySelectorAll('.accordion-item');
        accordion_items.forEach((item) => {
            item.querySelector('.accordion-item-body').style.maxHeight = null;
            item.classList.remove(this.CLASS_NAME_SHOW)
        });

        // Toggle the clicked item
        if(is_current_clicked_item_active){
            clicked_accordion_item.classList.remove(this.CLASS_NAME_SHOW);
        } else {
            let clicked_accordion_item_body = clicked_accordion_item.querySelector('.accordion-item-body');
            clicked_accordion_item_body.style.maxHeight = clicked_accordion_item_body.scrollHeight + "px";
            clicked_accordion_item.classList.add(this.CLASS_NAME_SHOW);
        }


    }

}
