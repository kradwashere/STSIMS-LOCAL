<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" style="--vz-modal-width: 600px;" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <template v-slot:header>
            <h5 class="modal-title">Update {{role}}</h5>
            <button @click="hide()" type="button" class="btn-close" aria-label="Close"></button>
        </template>
        <form class="customform mt-2">
            
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
            role:'',
            showModal: false
        }
    },
    methods: {
        show(data){
            this.role = data;
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