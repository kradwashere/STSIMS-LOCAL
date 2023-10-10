<template>
    <b-modal v-model="showModal" title="Released" hide-footer header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered>    
  
        <div class="modal-body text-center">
            <lottie colors="primary:#121331,secondary:#08a88a" trigger="loop"
                :options="defaultOptions1" :height="120" :width="120" />
            <div class="mt-1">
                <!-- <h4 class="mb-3">You've made it!</h4> -->
                <p class="mb-2">We have <span class="fw-semibold text-success">{{released}}</span> release that has not been checked.</p>
                <p class="text-muted fs-11 mb-4">This will update the released benefit status of the scholars. Please do it regularly to monitor the scholars correctly and update their benefit status.</p>
                <div class="hstack gap-2 justify-content-center mt-3">
                    <b-link @click="confirm()" href="javascript:void(0);" class="btn btn-sm btn-success">Please update the status now.</b-link>
                </div>
            </div>
        </div>

    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                showModal: false,
                isLoading: false,
                released: 0
            }
        },
        methods: {
            show(data) {
                this.released = data;
                this.showModal = true;
            },
            confirm(){
                this.isLoading = true;
                axios.post(this.currentUrl + '/monitoring', {
                    type: 'checked'
                })
                .then(response => {
                    this.isLoading = false;
                    this.hide();
                })
                .catch(err => console.log(err));
            },
            hide(){
                this.showModal = false;
            }
        }
    }
</script>
