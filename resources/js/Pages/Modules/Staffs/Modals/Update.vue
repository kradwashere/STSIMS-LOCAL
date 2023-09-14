<template>
    <b-modal v-model="showModal" :title="(type == 'status') ? 'Update Status' : 'Verify Staff'" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                <div class="col-md-12" v-if="type == 'status'">
                    <div v-if="list.is_active == 1" class="alert alert-danger alert-dismissible alert-additional mb-xl-0 mt-2" role="alert">
                        <div class="alert-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3"><i class="ri-alert-line fs-16 align-middle"></i></div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 mt-1"> Are you sure you want to <span class="fw-bold text-danger">deactivate</span> {{list.firstname}} {{list.lastname}}? </p>
                                </div>
                            </div>
                        </div>
                        <div class="alert-content"><p class="mb-0">This should block user from accessing the system. </p></div>
                    </div>
                    <div v-else class="alert alert-warning alert-dismissible alert-additional mb-xl-0 mt-2" role="alert">
                        <div class="alert-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3"><i class="ri-alert-line fs-16 align-middle"></i></div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 mt-1"> Are you sure you want to <span class="fw-bold text-warning">Activate</span> {{list.firstname}} {{list.lastname}}? </p>
                                </div>
                            </div>
                        </div>
                        <div class="alert-content"><p class="mb-0">This should allow user from accessing the system. </p></div>
                    </div>
                </div>
                <div v-else class="mt-4">
                    <div class="avatar-md mx-auto">
                        <div class="avatar-title rounded-circle bg-light">
                            <i class="bx bxs-envelope h1 mb-0 text-primary"></i>
                        </div>
                    </div>
                    <div class="p-2 mt-2 text-center">
                        <h6>Send Verification Link</h6>
                        <p class="font-size-12 text-muted"> Send Verification link to <span class="fw-bold">{{list.email}}</span> for activation. </p>
                    </div>
                </div>
            </div>
        </b-form>
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
            type: '',
            list: '',
            form: {},
            showModal: false,
            editable: false,
        }
    },

    methods : {
        show(type,data) {
            this.type = type;
            this.list = data;
            this.showModal = true;
        },

        create(){
            this.form = this.$inertia.form({
                id: this.list.id,
                is_active: (this.list.is_active == 1) ? 0 : 1,
                editable: true,
                type: this.type
            })

            this.form.put('/staffs/update',{
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
