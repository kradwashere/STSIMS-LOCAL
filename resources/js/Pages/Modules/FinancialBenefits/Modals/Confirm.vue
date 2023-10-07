<template>
    <b-modal v-model="showModal" title="Confirm Release" style="--vz-modal-width: 600px;" hide-footer header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered>    
        <b-form class="customform mb-2" v-if="selected">
            <div class="row">
                <div class="col-md-12">
                    <b-row>
                        <div class="responsive">
                            <table class="table table-centered table-bordered table-nowrap">
                                <thead class="thead-light align-middle text-center">
                                    <tr class="fw-bold fs-13 text-primary">
                                        <td colspan="2">{{selected.month.toUpperCase() }} BATCH {{selected.batch}} <span class="fs-12 fw-medium text-muted">({{selected.created_at}})</span></td>
                                    </tr>
                                    <tr class="fw-bold font-size-11">
                                        <td>No. of Scholars</td>
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                <tbody class="align-middle text-center">
                                    <tr>
                                        <td width="50%">{{selected.lists.length}} </td>
                                        <td width="50%">₱ {{ formatMoney(selected.total)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                         <input multiple class="mt-2 mb-4" type="file" :class="[($page.props.errors['files.'+0]) ? 'text-danger' : '']" @change="uploadFieldChange">
                        <div class="d-grid gap-2" >
                            <b-button @click="create()" variant="primary">Mark as Completed</b-button>
                        </div>
                    </b-row>
                </div>
            </div>
        </b-form>
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                showModal: false,
                selected: '',
                attachment: []
            }
        },

        methods: {
            set(data) {
                this.selected = data;
                this.showModal = true;
            },
            formatMoney(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
            uploadFieldChange(e) {
                e.preventDefault();
                var files = e.target.files || e.dataTransfer.files;

                if (!files.length)
                    return;
                for (var i = files.length - 1; i >= 0; i--) {
                    this.attachment.push(files[i]);
                }
            },
            create(){
                let data = new FormData();
                if(this.attachment.length > 0){
                    for (var i = this.attachment.length - 1; i >= 0; i--) {
                        data.append('attachment[]', this.attachment[i]);
                    }
                }
                data.append('type','Completed');
                data.append('id',this.selected.id);
                data.append('batch',this.selected.batch);

                // axios.post(this.currentUrl + '/financial-benefits', data)
                // .then(response => {
                //     this.showModal = false;
                // })
                // .catch(error => {
                //     if (error.response.status == 422) {
                //         this.errors = error.response.data.errors;
                //     }
                // });


                this.$inertia.post('/financial-benefits', data, {
                    preserveScroll: true,
                    forceFormData: true,
                    onSuccess: (response) => {
                        this.showModal = false;
                    },
                    onError: () => {
                        this.errors = this.$page.props.errors;
                    }
                });
            },
        }
    }
</script>
