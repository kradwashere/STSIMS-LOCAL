<template>
    <b-modal v-model="showModal" title="Create Disbursement" header-class="p-3 bg-light" style="--vz-modal-width: 590px;" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mt-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label>Expense: <span v-if="form.errors" v-text="form.errors.expense_id" class="haveerror"></span></label>
                       <Multiselect 
                        v-model="disbursement.expense" 
                        :options="expenses" :multiple="false" group-values="libs" group-label="language" :group-select="false" placeholder="Type to search" track-by="name" label="name"
                        />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Total Amount: <span v-if="form.errors" v-text="form.errors.amount" class="haveerror"></span></label>
                        <Amount @amount="amount" ref="testing" :readonly="false"/>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Allowed Amount:</label>
                        <input type="text" class="form-control test" v-money="money" v-model.lazy="bal" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label>Remarks: <span v-if="form.errors" v-text="form.errors.remarks" class="haveerror"></span></label>
                        <input type="text" class="form-control" v-model="disbursement.remarks">
                    </div>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="showModal = false" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" block>Save</b-button>
        </template>
    </b-modal>
</template>

<script>
import {VMoney} from 'v-money'
    import Amount from "@/Shared/Components/Amount.vue";
import Multiselect from '@suadelabs/vue3-multiselect';
export default {
    components : { Multiselect, Amount },
    directives: {money: VMoney},
    props: ['expenses'],
    data() {
        return {
            currentUrl: window.location.origin,
            form: {},
            disbursement: {
                amount: '',
                expense: '',
                remarks: ''
            },
            money: {
                decimal: '.',
                thousands: ',',
                prefix: '₱ ',
                precision: 2,
                masked: false
            },
            showModal: false
        }
    },
    computed: {
        bal: function(){
            return (this.disbursement.expense.amount) ? this.disbursement.expense.amount : 0
        }
    },  
    methods: {
        set() {
            this.showModal = true;
        },
        amount(val){
            this.disbursement.amount = val;
        },
        create(){
            this.form = this.$inertia.form({
                amount: this.disbursement.amount,
                expense_id: (this.disbursement.expense) ? this.disbursement.expense.id : '',
                allowed: (this.disbursement.expense) ? this.disbursement.expense.amount : '',
                remarks: (this.disbursement.remarks) ? this.disbursement.remarks : 'n/a',
                type: 'disbursement'
            })

            this.form.post('/accounting',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                    this.$emit('info',true);
                },
            });
        },
        hide(){
            this.disbursement = {
                expense : ''
            };
            this.$refs.testing.empty();
            this.showModal = false;
        }
    }
}
</script>
<style>
.multiselect__single { 
    font-size: 13px;
}
</style>
