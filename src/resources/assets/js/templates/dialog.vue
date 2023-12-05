<template>

    <div role="dialog">
        <div class="dialog-anchor">

            <!-- anchor -->
            <slot name="dialog-anchor"></slot>

        </div>
        <div class="dialog-overlay">
            <div class="floatingDialog dialog-content">

                <!-- content -->
                <slot name="dialog-content"></slot>

            </div>
        </div>
    </div>

</template>

<style lang="scss" scoped>

@import "../../sass/abstracts/colors";

[role=dialog] {

    display: inline-block;

    .dialog-anchor{
        cursor: pointer;

        .dontOpenDialog{
            cursor: default;
        }
    }

    .dialog-overlay{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba($gray-800, 0.7);
        backdrop-filter: blur(2px);
        z-index: 1;

        &.visible {
            display: block;
        }

        .dialog-content{
            display: none;
            position: fixed;
            top: 50vh;
            left: 50vw;
            transform: translate(-50%,-50%);
            max-height: 80vh;
            overflow-y: auto;

            &.visible {
                display: block;
            }

            background: white;
            padding: 10px;
            border-radius: 4px;
        }


    }

}


</style>

<script>
export default {

    data (){
        return {
            anchorElem: null,
            dialogElem: null,
            originalBodyOverflow: null
        }
    },

    mounted(){
        let _this = this;

        // retrieving elements
        this.anchorElem = this.$el.querySelector('.dialog-anchor');
        this.overlayElem = this.$el.querySelector('.dialog-overlay');
        this.dialogElem = this.$el.querySelector('.dialog-content');
        this.originalBodyOverflow = this.overlayElem.style.display.overflow;

        // open dialog on anchor click
        this.anchorElem.addEventListener('click',  function(evt){
            let clickedElem = evt.target;
            if(!clickedElem.classList.contains('dontOpenDialog') &&
                clickedElem.closest('.dontOpenDialog') == null){
                _this.openDialog();
            }
        });

        // close dialog on click outside dialog
        this.overlayElem.addEventListener('click', function(evt){
            let clickedElem = evt.target;
            if(clickedElem.closest('.dialog-content') == null){
                _this.closeDialog();
            }
        });

        // close dialog on role=closeDialog elements click
        this.dialogElem.querySelectorAll('[role="closeDialog"]')
            .forEach(function (item) {
                item.addEventListener('click', _this.closeDialog);
            });

    },

    methods: {

        openDialog(){
            document.querySelector('body').style.overflow = 'hidden';
            this.overlayElem.classList.add('visible');
            this.dialogElem.classList.add('visible');
        },

        closeDialog(){
            document.querySelector('body').style.overflow = this.originalBodyOverflow;
            this.dialogElem.classList.remove('visible');
            this.overlayElem.classList.remove('visible');
        }

    }

}
</script>
