<template>
    <b-modal v-model="showModal" title="Update Address"  style="--vz-modal-width: 600px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered>    
        <ul class="list-unstyled mb-0 vstack gap-3" v-if="user">
            <li>
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img :src="currentUrl+'/images/avatars/'+user.profile.avatar" alt="" class="avatar-sm rounded">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="fs-14 mb-1 text-primary">{{user.profile.name}}</h6>
                        <span :class="'badge bg-secondary bg-'+user.status.color">{{user.status.name}}</span>
                    </div>
                </div>
            </li>
            <hr class="text-muted mt-0" />
        </ul>

        <div class="alert alert-info alert-dismissible alert-label-icon rounded-label" role="alert">
            <i class="ri-map-2-line label-icon"></i>
            {{(user.address.info.barangay) ? user.address.info.barangay+', ' : ''}}
            {{user.address.info.municipality+', '}}
            {{user.address.info.province}}
        </div>


        <b-form class="customform mb-2">
            <div class="row customerform">
                <div class="col-md-12">
                    <div class="form-group" v-if="user.address.municipality == null">
                        <label>Municipality: <span v-if="errors.municipality_code" v-text="errors.municipality_code" class="haveerror"></span></label>
                            <multiselect 
                            v-model="municipality" 
                            :options="municipalities"
                            :allow-empty="false"
                            :show-labels="false"
                            label="name" track-by="code"
                            placeholder="Select Municipality">
                        </multiselect>
                    </div>
                </div>
                 <div class="col-md-12 mt-3">
                    <div class="form-group" v-if="user.address.barangay == null">
                        <label>Barangay: <span v-if="errors.barangay_code" v-text="errors.barangay_code" class="haveerror"></span></label>
                            <multiselect 
                            v-model="barangay" 
                            :options="barangays"
                            :allow-empty="false"
                            :show-labels="false"
                            label="name" track-by="code"
                            placeholder="Select Barangay">
                        </multiselect>
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
import Multiselect from '@suadelabs/vue3-multiselect';
export default {
    components: { Multiselect },
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            user: {
                status: {},
                address: {
                    info: {}
                },
                profile: {},
            },
            form : {},
            profile_id : '',
            lrn: '',
            program_id: '',
            municipalities: [],
            barangays: [],
            municipality: '',
            barangay: '',
            showModal: false,
        }
    },
    methods : {
        show(data){
            this.user = data;
            this.errors = [];
            if(this.user.address.municipality == null){
                this.fetchMunicipality(this.user.address.province.code);
            }else{
                this.fetchBarangay(this.user.address.municipality.code);
            }
            this.showModal = true;
        },
        hide(){
            this.showModal = false;
        },
        create(){
            let data = new FormData();

            data.append('id', this.user.id);
            data.append('type', 'update');
            data.append('is_completed', 1);
            data.append('address_id', this.user.address.id);
            (this.user.address.municipality == null) ? data.append('municipality_code', (this.municipality != '') ? this.municipality.code : '') : '';
            (this.user.address.barangay == null) ? data.append('barangay_code', (this.barangay != '') ? this.barangay.code : '') : '';
         

            this.$inertia.post('/qualifiers',data,{
                preserveScroll: true,
                forceFormData: true,
                onSuccess: (response) => {
                    this.clear();
                },
                onError: (response) =>{
                    this.errors.push(response);
                }
            });
        },
        clear(){
            this.barangay = '';
            this.municipality = '';
            this.showModal = false;
        },
        fetchMunicipality($id){
            axios.get(this.currentUrl + '/lists/municipalities/'+$id)
            .then(response => {
                this.municipalities = response.data.data;
            })
            .catch(err => console.log(err));
        },

        fetchBarangay($id){
            axios.get(this.currentUrl + '/lists/barangays/'+$id)
            .then(response => {
                this.barangays = response.data.data;
            })
            .catch(err => console.log(err));
        },
    }
}
</script>
