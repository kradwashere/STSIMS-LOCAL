<template>
    <b-modal v-model="showModal" title="View Financial Benefit" header-class="p-3 bg-light" size="xl" class="v-modal-custom" modal-class="zoomIn" centered hide-footer>    
        <b-form class="customform mb-2">
        
            <b-row class="mb-4 mt-2">
                <div class="responsive">
                    <table class="table table-centered table-bordered table-nowrap">
                        <thead class="thead-light align-middle text-center">
                            <tr class="fw-bold fs-12">
                                <td>Name</td>
                                <td>Total</td>
                            </tr>
                        </thead>
                        <tbody class="align-middle text-center fw-semibold text-primary fs-12">
                            <tr>
                                <td width="50%">{{breakdown.name}} </td>
                                <td width="50%">₱ {{ formatMoney(breakdown.total)}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-nowrap align-middle mb-0">
                        <thead class="table-dark">
                            <tr class="fs-11">
                                <th class="text-center" width="16%">Semester</th>
                                <th v-for="(l,index) in headers" v-bind:key="index" :width="73/headers.length+'%'" class="text-center">{{l}}</th>
                                <th class="text-center" width="11%">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(s,index) in semesters" v-bind:key="index">
                                <tr class="fs-11" v-if="(counts[index] != 0) ? true : false">
                                    <td class="text-center">{{semesters[index].academic_year}} - {{semesters[index].semester.name}}</td>
                                    <td v-for="(l,index) in headers" v-bind:key="index" class="text-center">
                                        ₱ {{calculate(l,s.id)}}
                                    </td>
                                    <td class="text-center"> 
                                        ₱ {{calculate('Total',s.id)}}
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <thead>
                            <tr class="table-light fs-11 fw-semibold">
                                <td class="text-center">Total</td>
                                <td v-for="(l,index) in headers" v-bind:key="index" class="text-center">
                                    ₱ {{formatMoney(check(l))}}
                                </td>
                                <td class="text-center">₱ {{formatMoney(breakdown.total)}}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </b-row>
        </b-form>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            selected: '',
            attachment: [],
            height: window.innerHeight - 557,
            breakdown: '',
            show: false,
            headers: [],
            semesters: [],
            totals: [],
            sums:[],
            counts: []
        }
    },
    methods : {
        set(data){
            this.headers = [];
            this.sums = [];
            this.semesters = [];
            this.totals = [];
            this.show = false;
            this.selected = data;
            this.showModal = true;
            this.counts = [];

            this.breakdown = data;
            console.log(data);

            this.breakdown.benefits.map((list) => {
                if (!this.headers.includes(list.benefit.short)) {
                    this.headers.push(list.benefit.short);
                }
            });

            this.breakdown.enrollments.map((list) => {
                if (!this.semesters.some(item => item.id === list.semester.id)) {
                    this.semesters.push(list.semester);
                }
                var benefitsLength = this.breakdown.benefits.filter((item) => item.school_semester_id == list.semester.id);
                this.counts.push(benefitsLength.length);
            });
            
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        calculate(data,semester){
            // if(data != 'Total'){
            //     var total = 0;
            //     this.breakdown.enrollments.map((list) => {
            //         if(list.semester.id == semester){
            //             list.semester.benefits.map((list) => {
            //                 if(list.benefit.name == data) {
            //                     total = parseInt(total) + parseInt(list.amount);
            //                 }
            //             });
            //         }
            //     });
            //     this.totals.push(total);
            //     return this.formatMoney(total);
            // }else{
            //     let t = this.formatMoney(this.totals.reduce((a, b) => a + b, 0));
            //     this.totals = [];
            //     return t;
            // };

            if(data != 'Total'){
                var total = 0;
               
                this.breakdown.benefits.map((list) => {
                    if(list.benefit.short == data) {
                        if(list.school_semester_id == semester){
                            total = parseInt(total) + parseInt(list.amount);
                        }
                    }
                });
                this.totals.push(total);
                return this.formatMoney(total);
            }else{
                let t = this.formatMoney(this.totals.reduce((a, b) => a + b, 0));
                this.totals = [];
                return t;
            };
            return 0;
        },
        check(l){
            var total = 0;
            this.breakdown.benefits.map((list) => {
                if(list.benefit.short == l) {
                    total = parseInt(total) + parseInt(list.amount);
                }
            });
            return total;
        }
    }
}
</script>