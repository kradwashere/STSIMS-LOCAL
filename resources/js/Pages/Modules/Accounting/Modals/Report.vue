<template>
    <b-modal v-model="showModal" title="Details of Financial Report" size="xl" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5 class="mt-2 mb-n4">{{checkQuarter(info.quarter)}}</h5>
                        </div>
                        <div class="flex-shrink-0">
                            <div>
                                <button @click="print()" class="btn btn-light"><i class="ri-printer-fill align-bottom"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-nowrap table-bordered align-middle mb-0 mt-3">
                            <thead class="table-dark">
                                <tr class="fs-11">
                                    <th style="width: 40%;">Expense Class</th>
                                    <th style="width: 15%;" class="text-center">Unexpended Balance</th>
                                    <th style="width: 15%;" class="text-center">Current Release</th>
                                    <th style="width: 15%;" class="text-center">Disbursement</th>
                                    <th style="width: 15%;" class="text-center">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="list in lists" v-bind:key="list.id">
                                    <tr class="table-light">
                                        <th class="fw-semibold">{{list.name}}</th>
                                        <th class="text-center">₱ {{formatMoney(sumBalances(list.list))}}</th>
                                        <th class="text-center">₱ {{formatMoney(sumAllotment(list.list))}}</th>
                                        <th class="text-center">₱ {{formatMoney(sumDisbursement(list.list))}}</th>
                                        <th class="text-center">₱ {{formatMoney((sumA+sumB) - sumD)}}</th>
                                    </tr>
                                    <template v-for="list in list.list" v-bind:key="list.id">
                                        <tr v-if="check(list)">
                                            <td>{{list.name}}</td>
                                            <td class="text-center">₱ {{formatMoney(list.balances_sum_amount)}}</td>
                                            <td class="text-center">₱ {{formatMoney(list.allotments_sum_amount)}}</td>
                                            <td class="text-center">₱ {{formatMoney(list.disbursements_sum_amount)}}</td>
                                            <td class="text-center">₱ 
                                                {{formatMoney((parseInt(list.balances_sum_amount)+parseInt(list.allotments_sum_amount)) - list.disbursements_sum_amount) }}
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold text-primary">
                                    <td class="text-uppercase">Total</td>
                                    <td class="text-center">₱ {{formatMoney(totalBalance)}}</td>
                                    <td class="text-center">₱ {{formatMoney(totalAllotment)}}</td>
                                    <td class="text-center">₱ {{formatMoney(totalDisbursement)}}</td>
                                    <td class="text-center text-success">₱ {{formatMoney((totalB+totalA) - totalD)}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="showModal = false" variant="light" block>Close</b-button>
        </template>
    </b-modal>
</template>
<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                showModal: false,
                lists: [],
                totalB: 0,
                totalA: 0,
                totalD: 0,
                sumB: 0,
                sumA: 0,
                sumD: 0,
                info: ''
            }
        },
        computed: {
            totalBalance: function(){
                let sum = 0;
                for(let i = 0; i < this.lists.length; i++){
                    for(let a = 0; a < this.lists[i].list.length; a++){
                        var temp = this.lists[i].list[a].balances_sum_amount;
                        sum += parseFloat(temp);
                    }
                }
                this.totalB = sum;
                return sum;
            },
            totalDisbursement: function(){
                let sum = 0;
                for(let i = 0; i < this.lists.length; i++){
                    for(let a = 0; a < this.lists[i].list.length; a++){
                        var temp = this.lists[i].list[a].disbursements_sum_amount;
                        sum += parseFloat(temp);
                    }
                }
                this.totalD = sum;
                return sum;
            },
            totalAllotment: function(){
                let sum = 0;
                for(let i = 0; i < this.lists.length; i++){
                    for(let a = 0; a < this.lists[i].list.length; a++){
                        var temp = this.lists[i].list[a].allotments_sum_amount;
                        sum += parseFloat(temp);
                    }
                }
                this.totalA = sum;
                return sum;
            }
        },
        methods: {
            set(latest){
                this.fetch();
                this.info = latest;
                this.showModal = true;
            },
            fetch() {
                axios.get(this.currentUrl + '/accounting', {
                    params: {
                        type: 'breakdowns',
                    }
                })
                .then(response => {
                    this.lists = response.data;
                })
                .catch(err => console.log(err));
            },
            sumDisbursement(arr) {
                var total = arr.reduce((total, num) => total + parseInt(num.disbursements_sum_amount), 0);
                this.sumD = total;
                return total;
            },
            sumAllotment(arr) {
                var total = arr.reduce((total, num) => total + parseInt(num.allotments_sum_amount), 0);
                this.sumA = total;
                return total;
            },
            sumBalances(arr) {
                var total = arr.reduce((total, num) => total + parseInt(num.balances_sum_amount), 0);
                this.sumB = total;
                return total;
            },
            formatMoney(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
            check(list){
                if(list.balances_sum_amount == 0 && list.allotments_sum_amount == 0 && list.disbursements_sum_amount == 0){
                    return false;
                }else{
                    return true;
                }
            },
            checkQuarter(val){
                if(val == 1){
                    return 'January 1 to March 31, 2013';
                }else if(val == 2){
                    return 'April 1 to June 30, 2013';
                }else if(val == 3){
                    return 'July 1 to September 30, 2013';
                }else{
                    return 'October 1 to December 31, 2013';
                }
            },
            print(){
                window.open(this.currentUrl + '/accounting/breakdown/edit');
            },
        }
    }
</script>
