<template>

    <span>
        <span>{{ formatted_date }}</span>
        <tooltip>
            {{ popUp }}
        </tooltip>
    </span>

</template>

<script>
    export default {
        props: {
            date: {
                type: String,
                default: null
            },
        },
        computed: {
            formatted_date: function(){
                if(this.date!==''){
                    let d = new Date(this.date),
                        month = '' + (d.getMonth() + 1).toString().padStart(2, '0'),
                        day = '' + d.getDate().toString().padStart(2, '0'),
                        year = d.getFullYear();
                    return [year, month, day].join('-');
                }
                return null;
            },
            popUp: function(){
                return this.date;
            }
        }
    }
</script>

<style>


</style>
