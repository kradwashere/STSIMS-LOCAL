<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" style="--vz-modal-width: 600px;" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <template v-slot:header>
            <h5 class="modal-title">Update Year</h5>
            <button @click="hide()" type="button" class="btn-close" aria-label="Close"></button>
        </template>
        <form class="customform mt-2">
            <!-- <div class="alert alert-info alert-dismissible alert-label-icon label-arrow" role="alert">
                <i class="ri-error-warning-fill label-icon"></i>Update when new school year
            </div> -->
            <div class="alert alert-info alert-borderless" role="alert">Year update helps to monitor scholar missed enrollment and monitors school active semesters. Please update when new School year is coming. </div>
            <!-- <p class="text-muted mb-4">Year update helps to monitor scholar missed enrollment. Please update when new School year is coming. And monitors school active semesters</p> -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Current Year:</label>
                        <input type="text" class="form-control" placeholder="Current Year" v-model="current_year" readonly/>     
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>New Year:</label>
                        <input type="text" class="form-control" placeholder="New Year" v-model="new_year" readonly/>     
                    </div>
                </div>
            </div>
            <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow mt-4" role="alert">
                <i class="ri-alert-line label-icon"></i><strong>Automatically</strong> updates all active semesters to <b>Inactive</b> 
            </div>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Update</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            form: {},
            current_year: '',
            new_year:'',
            showModal: false
        }
    },
    methods: {
        show(data){
            this.current_year = data;
            this.new_year = this.current_year + 1;
            this.showModal = true;
        },
        create(){
            this.form = this.$inertia.form({
                year: this.new_year
            })

            this.form.put('/settings/update',{
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