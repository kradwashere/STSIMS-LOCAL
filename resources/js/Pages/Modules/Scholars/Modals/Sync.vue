<template>
    <b-modal v-model="showModal" hide-footer header-class="p-3 bg-light" style="--vz-modal-width: 600px;" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <template v-slot:header>
            <h5 class="modal-title">Sync Scholar Updates</h5>
            <button @click="hide()" type="button" class="btn-close" aria-label="Close"></button>
        </template>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="p-2">
                    <div class="text-center">
                        <div class="avatar-md mx-auto">
                            <div class="avatar-title rounded-circle bg-light">
                                <i class="ri-upload-cloud-2-fill h1 mb-0 text-primary"></i>
                            </div>
                        </div>
                        <div class="p-2 mt-4">
                            <p class="text-muted">Sync all scholar information update to central server. <br />We found <b>{{count}}</b> data to be sync.</p>
                            <span v-if="isLoading"><i class='bx bx-loader-circle bx-spin mt-2'></i><span class="text-muted ms-1 mt-n4">Loading ... </span></span>
                            <div v-else class="mt-4">
                                <button @click="sync" type="button"  class="btn btn-primary w-lg">Sync</button>
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
            count: 0,
            form: {}
        }
    },
    methods : {
        show(count){
            this.count = count;
            this.showModal = true;
        },
        sync(){
            this.isLoading = true;
            this.form = this.$inertia.form({
                subtype: 'sync',
                type: 'api'
            })
            this.form.post('/scholars',{
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
