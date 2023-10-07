<template>
    <div class="d-flex">
        <div class="flex-grow-1">
            <h4>{{latest.code}}</h4>
            <div class="hstack gap-3 flex-wrap">
                <!-- <div><a class="text-primary d-block" href="#" target="_self">Tommy Hilfiger</a></div> -->
                <!-- <div class="vr"></div> -->
                <div class="text-muted"> Year : <span class="text-body fw-medium">{{latest.year}}</span></div>
                <div class="vr"></div>
                <div class="text-muted"> Quarter : <span class="text-body fw-medium">{{checkQuarter(latest.quarter)}}</span></div>
            </div>
        </div>
        <div class="flex-shrink-0">
            <div>
                <button @click="show(latest)" class="btn btn-light me-1">View Breakdown</button>
                <button class="btn btn-light"><i class="ri-printer-fill align-bottom"></i></button>
            </div>
        </div>
    </div>
    <table class="table table-nowrap table-bordered align-middle mb-0 mt-3">
        <thead class="table-light">
            <tr class="fs-11">
                <th style="width: 15%;" class="text-center">Check Date</th>
                <th style="width: 15%;" class="text-center">Check No.</th>
                <th style="width: 14%;" class="text-center">Amount</th>
                <th style="width: 14%;" class="text-center">Previous Balance</th>
                <th style="width: 14%;" class="text-center">Total</th>
                <th style="width: 14%;" class="text-center">Disbursement</th>
                <th style="width: 14%;" class="text-center">Balance</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(allotment,index) in allotments" v-bind:key="allotment.id">
                <td class="text-center">{{allotment.checked_at}}</td>
                <td class="text-center">{{allotment.check_no}}</td>
                <td class="text-center">₱ {{formatMoney(allotment.lists_sum_amount)}}</td>
                <td v-if="index == 0" :rowspan="allotments.length" class="text-center"></td>
                <td v-if="index == 0" :rowspan="allotments.length" class="text-center"></td>
                <td v-if="index == 0" :rowspan="allotments.length" class="text-center"></td>
                <td v-if="index == 0" :rowspan="allotments.length" class="text-center"></td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="fw-semibold fs-12">
                <td colspan="2"></td>
                <td class="text-center">₱ {{formatMoney(total)}}</td>
                <td class="text-center">₱ {{formatMoney(previous)}}</td>
                <td class="text-center">₱ {{formatMoney(parseInt(total)+parseInt(previous))}}</td>
                <td class="text-center">₱ {{formatMoney(disbursement)}}</td>
                <td class="text-center">₱ {{formatMoney((parseInt(total)+parseInt(previous))-disbursement)}}</td>
            </tr>
        </tfoot>
    </table>
    <Report ref="report"/>
</template>
<script>
import Report from './Modals/Report.vue';
export default {
    components: { Report },
    props: ['latest', 'old'],
    data(){
        return {
            currentUrl: window.location.origin,
            allotments: [],
            total: 0,
            previous: (this.old) ? this.old.balance : 0,
            disbursement: 0
        }
    },
    created(){
        this.fetch();
    },
    methods: {
        fetch() {
            axios.get(this.currentUrl + '/accounting', {
                params: {
                    type: 'reports',
                }
            })
            .then(response => {
                this.allotments = response.data.allotments;
                this.total = response.data.total_allotment;
                this.disbursement = response.data.total_disbursement;
            })
            .catch(err => console.log(err));
        },
        show(latest){
            this.$refs.report.set(latest);
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        checkQuarter(val){
            if(val == 1){
                return '1st';
            }else if(val == 2){
                return '2nd';
            }else if(val == 3){
                return '3rd';
            }else{
                return '4th';
            }
        }
    }
}
</script>
