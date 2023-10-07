<template>
    <b-modal v-model="showModal" title="Release Benefits" style="--vz-modal-width: 600px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12 mt-2" v-if="scholars">
                    <div class="responsive">
                        <table class="table table-centered table-bordered table-nowrap">
                            <thead class="thead-light align-middle text-center">
                                <tr class="fw-bold font-size-13 text-primary">
                                    <td colspan="2">{{info.month.toUpperCase() }} RELEASE NO.{{info.count+1}}</td>
                                </tr>
                                <tr class="fw-bold font-size-11">
                                    <td>No. of Scholars</td>
                                    <td>Total</td>
                                </tr>
                            </thead>
                            <tbody class="align-middle text-center">
                                <tr>
                                    <td width="50%">{{scholars.length}} </td>
                                    <td width="50%">₱ {{ formatMoney(total)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" v-model="dv" type="checkbox" id="gridCheck"/>
                        <label class="form-check-label" for="gridCheck">Do you want to add Disbursement Voucher?</label>
                    </div>
                    <input v-if="dv" type="text" class="form-control mt-3" placeholder="Disbursement Voucher" v-model="dv_no"/>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="showModal = false" variant="light" block>Cancel</b-button>
            <b-button @click="save('ok')" variant="primary"  block>Save</b-button>
        </template>
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                scholar: '',
                total: 0,
                info: '',
                showModal: false,
                dv: false,
                dv_no: '',
            }
        },

        methods: {
            set(scholars,info){
                this.scholars = scholars;
                this.total = this.scholars.map(({total}) => total).reduce((a, b) => a + b, 0);
                this.info = info;
                this.showModal = true;
            },
            formatMoney(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
            save(){
                this.form = this.$inertia.form({
                    'lists': this.scholars,
                    'total': this.total,
                    'dv': this.dv,
                    'dv_no': this.dv_no,
                    'number': this.info.count+1
                })
                this.form.post('/financial-benefits',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.showModal = false;
                        this.$parent.$parent.$parent.fetchLatest();
                    }
                });
            },
        }
    }
</script>
