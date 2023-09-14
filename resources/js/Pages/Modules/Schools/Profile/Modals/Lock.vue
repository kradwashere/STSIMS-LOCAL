<template>
    <b-modal v-model="showModal" title="Lock Enrollment Information" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform">
            <div class="row">
                <div class="col-md-12 mt-2 mb-n3" v-if="!prospectus.is_locked">
                    <div class="alert alert-danger alert-dismissible alert-label-icon rounded-label" role="alert"><i class="ri-error-warning-line label-icon"></i>You won't be able to update the prospectus anymore! </div>
                </div>
                 <div class="col-md-12 mt-2 mb-n3" v-else>
                    <div class="alert alert-warning alert-dismissible alert-label-icon rounded-label" role="alert"><i class="ri-error-warning-line label-icon"></i>You will be able to update the prospectus again! </div>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="showModal = false" variant="light" block>Cancel</b-button>
            <b-button @click="save('ok')" variant="primary"  block>Update</b-button>
        </template>
    </b-modal>
</template>

<script>
export default {
    props: ['lists'],
    data() {
        return {
            currentUrl: window.location.origin,
            showModal: false,
            prospectus: ''
        }
    },
    methods: {
        set(data){
            this.prospectus = data;
            this.showModal = true;
        },
        save(){
            this.form = this.$inertia.form({
                id: this.prospectus.id,
                is_locked: (this.prospectus.is_locked) ? 0 : 1,
                editable: (this.prospectus.is_locked) ? true : false,
                type: 'lock'
            })

            this.form.put('/schools/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.showModal = false;
                }
            });
        }
    }
}
</script>
