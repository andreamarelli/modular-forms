<template>

    <span>
        <span>{{ user_name }}</span>
        <tooltip>
            {{ popUp }}
        </tooltip>
    </span>

</template>

<script>
    export default {
        props: {
            user_name : String,
            user_id : Number,
        },
        computed: {
            popUp: function(){
                if(this.user_id!==null){
                    return '#' + this.user_id.toString();
                }
                return '';
            }
        }
    }
</script>

<style>


</style>
