<template>
    <input type="text" class="form-control test" v-money="money" v-model.lazy="value" :readonly="readonly">
</template>
<script>
import {VMoney} from 'v-money'
export default {
    props: ['readonly'],
    data(){
        return {
            value: 0,
            money: {
                decimal: '.',
                thousands: ',',
                prefix: '₱ ',
                precision: 2,
                masked: false
            },
        }
    },
    watch: {
        value: function(val){
            this.$emit('amount',val)
        }
    },
    methods: {
        empty(){
            this.value = 0;
        }
    },
    directives: {money: VMoney},
}
</script>