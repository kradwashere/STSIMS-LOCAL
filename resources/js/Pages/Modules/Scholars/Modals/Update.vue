<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" style="--vz-modal-width: 600px;" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <template v-slot:header>
            <h5 class="modal-title">Update Scholar</h5>
            <button @click="hide()" type="button" class="btn-close" aria-label="Close"></button>
        </template>
        <ul class="list-unstyled mb-0 vstack gap-3" v-if="user">
            <li>
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0" v-if="user.profile.avatar">
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

        <div v-if="user.addresses.length > 0 && type == 'address'" class="alert alert-info alert-dismissible alert-label-icon rounded-label" role="alert">
            <i class="ri-map-2-line label-icon"></i>
            {{(user.addresses[0].info.address) ? user.addresses[0].info.address+', ' : ''}}
            {{(user.addresses[0].info.barangay) ? user.addresses[0].info.barangay+', ' : ''}}
            {{user.addresses[0].info.municipality+', '}}
            {{user.addresses[0].info.province}}
        </div>
        <b-form class="customform mb-2">
            <div class="row customerform">

                <div class="col-md-12 mt-4">
                    <div class="form-group"  v-if="type == 'scholar'">
                        <label>Account No.: <span v-if="form.errors" v-text="form.errors.account_no" class="haveerror"></span></label>
                        <input type="text" class="form-control" v-model="user.account_no" v-maska data-maska="####-####-##">
                    </div>
                </div>

                 <div class="col-md-12" v-if="type == 'status'">
                    <label>Status: <span v-if="errors.length > 0" class="haveerror">({{ errors[0].level_id }})</span></label>
                    <multiselect 
                        v-model="status" 
                        id="ajax" 
                        label="name" track-by="id"
                        placeholder="Select Status" 
                        open-direction="bottom" 
                        :options="status_lists"
                        :searchable="true" 
                        :allow-empty="false"
                        :show-labels="false">
                    </multiselect> 
                </div>

                <div class="col-md-12" v-if="!user.education.has_school && type == 'education'">
                    <label>School: <span v-if="errors.length > 0" class="haveerror">({{ errors[0].school_id }})</span></label>
                    <multiselect v-model="education.school" id="ajax" label="name" track-by="id"
                        placeholder="Search School" open-direction="bottom" :options="schools"
                        :searchable="true" 
                        :allow-empty="false"
                        :show-labels="false"
                        @search-change="asyncSchool">
                    </multiselect> 
                </div>
                <div class="col-md-12" v-if="!user.education.has_level && user.status.type == 'Ongoing' && type == 'education'">
                    <label>Level: <span v-if="errors.length > 0" class="haveerror">({{ errors[0].level_id }})</span></label>
                    <multiselect 
                        v-model="education.level" 
                        id="ajax" 
                        label="name" track-by="id"
                        placeholder="Select Level" 
                        open-direction="bottom" 
                        :options="levels"
                        :searchable="true" 
                        :allow-empty="false"
                        :show-labels="false">
                    </multiselect> 
                </div>
                <div class="col-md-12 mt-2">
                    <div class="form-group"  v-if="type == 'education' && user.status.name == 'Graduated' && user.education.graduated_year == 'n/a'">
                        <label>Graduated Year: <span v-if="form.errors" v-text="form.errors.graduated_year" class="haveerror"></span></label>
                        <input class="form-control" v-model="education.graduated_year" v-maska data-maska="####" type="text">
                    </div>
                </div>
                <div class="col-md-12 mt-2 mb-1" v-if="user.status.name == 'Graduated' && type == 'education'">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" v-model="has_award" id="gridCheck"/>
                        <label class="form-check-label" for="gridCheck">Does the scholar has Academic award?</label>
                    </div>
                </div>
                <div class="col-md-12" v-if="user.status.name == 'Graduated' && has_award == true && type == 'education'">
                    <label>Award: <span v-if="errors.length > 0" class="haveerror">({{ errors[0].award_id }})</span></label>
                    <multiselect 
                        v-model="education.award" 
                        id="ajax" 
                        label="name" track-by="id"
                        placeholder="Select Award" 
                        open-direction="bottom" 
                        :options="awards"
                        :searchable="true" 
                        :allow-empty="false"
                        :show-labels="false">
                    </multiselect> 
                </div> 

                <div class="col-md-12" v-if="user.addresses.length > 0 && type == 'address'">
                    <div class="form-group" v-if="user.addresses[0].municipality == null">
                        <label>Municipality: <span v-if="errors.municipality_code" v-text="errors.municipality_code" class="haveerror"></span></label>
                            <multiselect 
                            v-model="address.municipality" 
                            :options="municipalities"
                            :allow-empty="false"
                            :show-labels="false"
                            label="name" track-by="code"
                            placeholder="Select Municipality">
                        </multiselect>
                    </div>
                </div>
                <div class="col-md-12 mt-3" v-if="user.addresses.length > 0 && type == 'address'">
                    <div class="form-group" v-if="user.addresses[0].barangay == null">
                        <label>Barangay: <span v-if="errors.barangay_code" v-text="errors.barangay_code" class="haveerror"></span></label>
                            <multiselect 
                            v-model="address.barangay" 
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
import { vMaska } from "maska"
import Multiselect from '@suadelabs/vue3-multiselect';
export default {
    directives: { maska: vMaska },
    components: { Multiselect },
    props: ['statuses', 'dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            user: {
                status: {},
                education: {
                    school: {}, course: {}
                },
                addresses: [],
                profile: {},
                account_no: '',
            },
            education : {
                level: '',
                graduated_year: '',
                award: '',
                school: '',
                course: '',
            },
            address: {
                municipality: '',
                barangay: ''
            },
            schools: [],
            course: [],
            barangays: [],
            municipalities: [],
            form: {},
            type: '',
            status: '',
            has_award: false
        }
    },
    computed:{
        levels : function() {
            return this.dropdowns.filter(x => x.classification === 'Level');
        },
        awards : function() {
            return this.dropdowns.filter(x => x.classification === 'Award');
        },
        status_lists : function() {
            return this.statuses.filter(x => x.type === 'Progress' || x.type === 'Ongoing');
        }
    },
    methods : {
        show(data,type){
            this.type = type;
            this.user = data;
            this.errors = [];
            if(type == 'address'){
                if(this.user.addresses[0].municipality == null){
                    this.fetchMunicipality(this.user.addresses[0].province.code);
                }else{
                    this.fetchBarangay(this.user.addresses[0].municipality.code);
                }
            }
            this.showModal = true;
        },
        create(){
            let data = new FormData();

            data.append('id', this.user.id);
            data.append('type', 'update');
            data.append('subtype', (this.type != 'scholar' && this.type != 'status') ? this.type : 'scholar');
            data.append('is_completed', 1);
            data.append('is_synced', 0);

            if(this.type == 'education'){
                data.append('education_id', this.user.education.id);
                (this.type == 'education' && this.user.status.name == 'Graduated' && this.user.education.graduated_year == 'n/a') ? data.append('graduated_year',this.education.graduated_year) : '';
                (!this.user.education.has_level && this.user.status.type == 'Ongoing') ? data.append('level_id', (this.education.level != '') ? this.education.level.id : '') : '';
                (this.has_award) ? data.append('award_id', (this.education.award != '') ? this.education.award.id : '') : '';
            }else if(this.type == 'address'){
                data.append('address_id', this.user.addresses[0].id);
                (this.user.addresses[0].municipality == null) ? data.append('municipality_code', (this.address.municipality != '') ? this.address.municipality.code : '') : '';
                (this.user.addresses[0].barangay == null) ? data.append('barangay_code', (this.address.barangay != '') ? this.address.barangay.code : '') : '';
            }else{
                (this.user.account_no != null) ? data.append('account_no', this.user.account_no) : ''; 
                (this.status != null) ? data.append('status_id', this.status.id) : '';
            }

            this.$inertia.post('/scholars',data,{
                preserveScroll: true,
                forceFormData: true,
                onSuccess: (response) => {
                    this.hide();
                },
                onError: (response) =>{
                    this.errors.push(response);
                    // console.log(this.errors[0].course_id)
                }
            });
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
        hide(){
            this.showModal = false;
        }
    }
}
</script>
