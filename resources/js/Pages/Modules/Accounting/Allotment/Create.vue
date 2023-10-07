<template>
    <b-modal v-model="showModal" title="Create Allotment" header-class="p-3 bg-light" style="--vz-modal-width: 590px;" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2 mt-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Check Number: <span v-if="form.errors" v-text="form.errors.check_no" class="haveerror"></span></label>
                        <input type="text" class="form-control" v-model="allotment.check_no">
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Checked At: <span v-if="form.errors" v-text="form.errors.checked_at" class="haveerror"></span></label>
                    <date-picker
                        v-model:value="allotment.checked_at"
                        format="YYYY-MM-DD"
                        lang="en"
                        placeholder="Select Month"
                        >
                    </date-picker>
                </div>
                <div class="col-md-6">
                    <label>Credited At: <span v-if="form.errors" v-text="form.errors.credited_at" class="haveerror"></span></label>
                    <date-picker
                        v-model:value="allotment.credited_at"
                        format="YYYY-MM-DD"
                        lang="en"
                        placeholder="Select Month"
                        >
                    </date-picker>
                </div>
                 <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <label>Remarks: <span v-if="form.errors" v-text="form.errors.remarks" class="haveerror"></span></label>
                        <input type="text" class="form-control" v-model="allotment.remarks">
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
import DatePicker from 'vue-datepicker-next';
import 'vue-datepicker-next/index.css';
export default {
    components : { DatePicker },
    data() {
        return {
            currentUrl: window.location.origin,
            form: {},
            allotment: {
                check_no: '',
                checked_at: '',
                credited_at: '',
                remarks: ''
            },
            showModal: false
        }
    },
    methods: {
        set() {
            this.showModal = true;
        },
        create(){
            this.form = this.$inertia.form({
                check_no: this.allotment.check_no,
                credited_at: (this.allotment.credited_at != '') ? new Date(this.allotment.credited_at).toLocaleDateString("af-ZA") : '',
                checked_at: (this.allotment.checked_at != '') ? new Date(this.allotment.checked_at).toLocaleDateString("af-ZA"): '',
                remarks: (this.allotment.remarks) ? this.allotment.remarks : 'n/a',
                type: 'allotment'
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
            this.allotment = {};
            this.showModal = false;
        }
    }
}
</script>
