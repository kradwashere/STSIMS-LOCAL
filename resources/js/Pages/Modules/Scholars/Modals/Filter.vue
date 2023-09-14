<template>
    <div class="offcanvas offcanvas-start" :class="showOff ? 'show' : 'hiding'"  tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header bg-primary">
            <h5 class="offcanvas-title text-white" id="offcanvasExampleLabel">
                Scholar Filter
            </h5>
            <button type="button" class="btn-close text-white" @click="showOff = false"></button>
        </div>
        <b-form action="" class="d-flex flex-column justify-content-end h-100 bg-gradient">
            <div class="offcanvas-body">
                <!-- <div class="mb-2">
                    <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-1 fs-11">Program</label>
                    <multiselect 
                        v-model="program" 
                        :options="programs"
                        :allow-empty="false"
                        :show-labels="false"
                        label="name" track-by="id"
                        placeholder="Select Program">
                    </multiselect>
                </div>
                <div class="mb-2">
                    <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-1 fs-11">Status</label>
                    <multiselect 
                        v-model="status" 
                        :options="status"
                        :allow-empty="false"
                        :show-labels="false"
                        label="name" track-by="id"
                        placeholder="Select Status">
                    </multiselect>
                </div> -->
                <div class="mb-2">
                    <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-1 fs-11">Subprogram</label>
                    <multiselect 
                        v-model="subprogram" 
                        :options="programs"
                        :allow-empty="false"
                        :show-labels="false"
                        label="name" track-by="id"
                        placeholder="Select Subprogram">
                    </multiselect>
                </div>
                <hr class="mt-4"/>
                <div class="mb-2">
                    <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-1 fs-11">School</label>
                    <multiselect 
                        v-model="school" 
                        :options="schools"
                        :allow-empty="false"
                        :show-labels="false"
                        @search-change="asyncSchool"
                        label="name" track-by="id"
                        placeholder="Select School">
                    </multiselect>
                </div>
                <div class="mb-2">
                    <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-1 fs-11">Course</label>
                    <multiselect 
                        v-model="course" 
                        :options="courses"
                        :allow-empty="false"
                        @search-change="asyncCourse"
                        :show-labels="false"
                        label="name" track-by="id"
                        placeholder="Select Course">
                    </multiselect>
                </div>
                <hr class="mt-4"/>
                <div class="mb-2">
                    <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-1 fs-11">Region</label>
                     <multiselect 
                        @input="onChangeRegion(region.code)"
                        v-model="region" 
                        :options="regions"
                        :allow-empty="true"
                        :show-labels="false"
                        label="region" track-by="code"
                        placeholder="Select Region">
                    </multiselect>
                </div>

                <div class="mb-2">
                    <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-1 fs-11">Province</label>
                     <multiselect 
                        @input="onChangeProvince(province.code)"
                        v-model="province" 
                        :options="provinces"
                        :allow-empty="true"
                        :show-labels="false"
                        label="name" track-by="code"
                        placeholder="Select Province">
                    </multiselect>
                </div>

                <div class="mb-2">
                    <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-1 fs-11">Municipality</label>
                     <multiselect 
                        v-model="municipality" 
                        @input="onChangeMunicipality(municipality.code)"
                        :options="municipalities"
                        :allow-empty="false"
                        :show-labels="true"
                        label="name" track-by="code"
                        placeholder="Select Municipality">
                    </multiselect>
                </div>

                <div class="mb-2">
                    <label for="country-select" class="form-label text-muted text-uppercase fw-semibold mb-1 fs-11">Barangay</label>
                     <multiselect 
                        v-model="barangay" 
                        :options="barangays"
                        :allow-empty="true"
                        :show-labels="false"
                        label="name" track-by="code"
                        placeholder="Select Barangay">
                    </multiselect>
                </div>
            </div>
            <div class="offcanvas-footer border-top p-3 text-center hstack gap-2">
                <b-button @click="clear()" type="button" variant="light" class="w-100">Clear Filter</b-button>
                <b-button @click="fill()" type="button" variant="success" class="w-100">
                    Filter
                </b-button>
            </div>
        </b-form>
    </div>
</template>
<script>
import Multiselect from '@suadelabs/vue3-multiselect';
export default {
    components : { Multiselect },
    props : ['regions', 'programs'],
    data(){
        return {
            currentUrl: window.location.origin,
            provinces: [],
            municipalities: [],
            barangays: [],
            region: '',
            province: '',
            municipality: '',
            barangay: '',
            schools: [],
            courses: [],
            statuses:[],
            subprogram: '',
            school: '',
            course: '',
            program: '',
            status:'',
            filter: '',
            year: '',
            showOff: false
        }
    },
    watch: {
        region(){
            this.province = '';
            this.municipality = '';
            this.barangay = '';
            this.fetchProvince(this.region.code);
        },
        province(){
            this.barangay = '';
            this.municipality = '';
            this.fetchMunicipality(this.province.code);
        },
        municipality(){
            this.barangay = '';
            this.fetchBarangay(this.municipality.code);
        }
    },
    methods: {
        fill(){
            this.filter = {
                'region' : (this.region != null) ? this.region.code : '',
                'province' : (this.province != null) ? this.province.code : '',
                'municipality' : (this.municipality != null) ? this.municipality.code : '',
                'barangay' : (this.barangay != null) ? this.barangay.code : '',
                'school' : (this.school != null) ? this.school.id : '',
                'course' : (this.course != null) ? this.course.id : '',
                'subprogram' : (this.subprogram != null) ? this.subprogram.id : '',
            };
            this.$emit('status', this.filter);
        },
        show(){
            this.showOff = true;
        },
        asyncSchool(value) {
            if(value.length > 5){
                axios.post(this.currentUrl + '/lists/search/schools', {
                    word: value,
                })
                .then(response => {
                    this.schools = response.data.data;
                })
                .catch(err => console.log(err));
            }
        },

        asyncCourse(value) {
            if(value.length > 5){
                axios.post(this.currentUrl + '/lists/search/courses', {
                    word: value,
                })
                .then(response => {
                    this.courses = response.data.data;
                })
                .catch(err => console.log(err));
            }
        },

        fetchProvince($id){
            axios.get(this.currentUrl + '/lists/provinces/'+$id)
            .then(response => {
                this.provinces = response.data.data;
            })
            .catch(err => console.log(err));
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
        clear(){
            this.region = '';
            this.province = '';
            this.municipality = '';
            this.barangay = '';
            this.school = '';
            this.course = '';
            this.program = '';
            this.subprogram = '';
            this.status = '';
            this.year = '';
        }
    }
}
</script>