<template>
    <b-modal v-model="showModal" title="Create Prospectus" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                <div class="col-md-12 mt-2">
                   <div class="form-group">
                        <label>Prospectus Name:</label>
                        <input type="text" class="form-control" v-model="schoolyear">
                    </div>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Save</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    props: ['type'],
    data(){
        return {
            showModal: false,
            schoolyear: '',
            course: '',
            id: '',
            years: '',
            editable: false,
            form: {}
        }
    },

    methods : {
        show(data) {
            this.id = data.id;
            this.years = data.years;
            this.showModal = true;
        },

        create(){
            this.form = this.$inertia.form({
                school_year: this.schoolyear,
                school_course_id : this.id,
                years : this.years,
                editable: false,
                subtype: this.type,
                type: 'prospectus'
            })

            this.form.post('/schools',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },

        hide(){
            // this.$emit('status', true);
            // (this.form.hasOwnProperty('reset') ) ? this.form.reset().clearErrors() : this.semester = {};
            this.showModal = false;
        },
    }
}
</script>
