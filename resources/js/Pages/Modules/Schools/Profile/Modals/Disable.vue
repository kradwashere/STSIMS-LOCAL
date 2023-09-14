<template>
    <b-modal v-model="showModal" title="Disable Grade" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                <div class="col-md-12 mt-2 mb-1">
                    <div>
                        <table class="table table-bordered align-middle mt-n2">
                            <thead class="text-center table-light">
                                <tr>
                                    <th>Grade</th>
                                    <th>Upper Limit</th>
                                    <th>Lower Limit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="mb-n4 text-center">
                                    <td width="25%">
                                        {{data.grade}} <span v-if="data.is_failed">/ F</span>
                                    </td>
                                    <td width="30%">
                                        {{data.upper_limit}}
                                    </td>
                                    <td width="30%">
                                        {{data.lower_limit}}
                                   </td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <span>Are you sure you want to <span v-if="data.is_active" class="text-danger fw-semibold">disable</span> <span v-else class="text-success fw-semibold">enable</span> the grade?</span>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Confirm</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            showModal: false,
            data: '',
            form: {},
            editable: false,
        }
    },


    methods : {
        show(data) {
            this.data = data;
            this.showModal = true;
        },

        create(){
            this.form = this.$inertia.form({
                id: this.data.id,
                is_active: (this.data.is_active) ? false : true,
                type: 'disable'
            })

            this.form.put('/schools/update',{
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
