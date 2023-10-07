<template>
    <b-modal v-model="showModal" hide-footer header-class="p-3 bg-light" style="--vz-modal-width: 600px;" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <template v-slot:header>
            <h5 class="modal-title">Truncate Scholars</h5>
            <button @click="hide()" type="button" class="btn-close" aria-label="Close"></button>
        </template>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="p-2">
                    <div class="text-center">
                        <div class="avatar-md mx-auto">
                            <div class="avatar-title rounded-circle bg-light">
                                <i class="ri-delete-bin-2-fill h1 mb-0 text-danger"></i>
                            </div>
                        </div>
                        <div class="p-2 mt-4">
                            <p class="text-muted">Truncate all scholars from database. This will empty all tables with scholars relationship. <b>For Development Only</b></p>
                            <span v-if="isLoading"><i class='bx bx-loader-circle bx-spin mt-2'></i><span class="text-muted ms-1 mt-n4">Loading ... </span></span>
                            <div v-else class="mt-4">
                                <button @click="truncate" type="button"  class="btn btn-danger w-lg">Truncate</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            isLoading: false,
            form: {}
        }
    },
    methods : {
        show(){
            this.showModal = true;
        },
        truncate(){
            this.isLoading = true;
            this.form = this.$inertia.form({
                subtype: 'schools',
                type: 'truncate'
            })
            this.form.post('/schools',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        hide(){
            this.isLoading = false;
            this.showModal = false;
        }
    }
}
</script>
