<template>
    <b-modal v-model="showModal" title="Benefits" style="--vz-modal-width: 50%;" hide-footer header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered>    
        <b-row class="mb-4 mt-2">
            <div class="responsive">
               
                <table class="table table-bordered table-nowrap align-middle mb-0">
                    <thead class="table-dark">
                        <tr class="fs-11">
                            <th width="5%">#</th>
                            <th width="30%">Benefit</th>
                            <th class="text-center" width="25%">Month</th>
                            <th class="text-center" width="20%">Status</th>
                            <th class="text-center" width="20%">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(list,index) in benefits" v-bind:key="list.id">
                            <td class="text-center">{{index + 1}}</td>
                            <td>
                                <h5 class="fs-12 mb-0 text-dark">{{list.benefit.name}}</h5>
                            </td>
                            <td class="fs-12 text-center">{{list.month}}</td>
                            <td class="text-center">
                                <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                            </td>
                            <td class="text-center">{{formatMoney(list.amount)}}</td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr class="table-light fs-12 fw-semibold">
                            <td colspan="3"></td>
                            <td class="text-center">Total</td>
                            <td class="text-center text-primary">{{calculateTotalSum()}}</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </b-row>  
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                showModal: false,
                benefits: []
            }
        },
        methods: {
            show(data) {
                this.benefits = data;
                this.showModal = true;
            },
            formatMoney(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
            calculateTotalSum() {
                return this.formatMoney(this.benefits.reduce((accumulator, currentValue) => accumulator + parseInt(currentValue.amount), 0));
            }
        }
    }
</script>
