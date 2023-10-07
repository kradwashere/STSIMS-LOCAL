<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" style="--vz-modal-width: 600px;" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <template v-slot:header>
            <h5 class="modal-title">Create Expense Class</h5>
            <button @click="hide()" type="button" class="btn-close" aria-label="Close"></button>
        </template>
        <form class="customform mt-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label>Name : <span v-if="form.errors" v-text="form.errors.name" class="haveerror"></span></label>
                        <input type="text" class="form-control" v-model="expense.name">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label>Expenditure: <span v-if="form.errors" v-text="form.errors.expenditure_id" class="haveerror"></span></label>
                        <Multiselect 
                        v-model="expense.expenditure" 
                        :options="expenditures"  
                        placeholder="Type to search" 
                        track-by="id" label="name"
                        />
                    </div>
                </div>
            </div>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Save</b-button>
        </template>
    </b-modal>
</template>
<script>
import Multiselect from '@suadelabs/vue3-multiselect';
export default {
    components : { Multiselect },
    props: ['expenditures'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: {},
            expense: {
                name: '',
                expenditure: '',
            },
            showModal: false
        }
    },
    methods: {
        show(){
            this.showModal = true;
        },
        create(){
            this.form = this.$inertia.form({
                name: this.expense.name,
                expenditure_id: (this.expense.expenditure) ? this.expense.expenditure.id : '',
                type: 'expense'
            })

            this.form.post('/accounting',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        hide(){
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