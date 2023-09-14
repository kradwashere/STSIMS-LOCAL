<template>
    <b-row class="g-2 mb-1 mt-n1">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="keyword" placeholder="Search School" class="form-control" style="width: 30%;">
            </div>
        </b-col>
    </b-row>
    <b-row class="g-2 mb-3 mt-n1">
        <b-col lg>
            <b-row>
                <div class="col-md-4">
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
                <div class="col-md-4">
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
                <div class="col-md-4">
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
            </b-row>
        </b-col>
    </b-row>

    <div class="table-responsive">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th></th>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 15%;" class="text-center">Class</th>
                    <th style="width: 15%;" class="text-center">Term</th>
                    <th style="width: 15%;" class="text-center">Grading</th>
                    <th style="width: 15%;" class="text-center">Status</th>
                    <th style="width: 10%;"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="list in lists" v-bind:key="list.id" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                    <td>
                        <div class="avatar-xs chat-user-img online">
                            <span v-if="list.avatar == 'school.jpg'" :class="'avatar-title rounded-circle bg-primary text-white'">{{list.name[0]}}</span>
                            <img v-else :src="currentUrl+'/images/avatars/'+list.avatar" alt="" class="avatar-xs rounded-circle">
                            <span v-if="list.is_main" class="user-status text-success"></span>
                        </div>
                    </td>
                    <td>
                        <h5 class="fs-13 mb-0 text-dark">{{list.display}}</h5>
                        <p class="fs-12 text-muted mb-0">{{list.address}}</p>
                    </td>
                    <td class="text-center">{{list.class}}</td>
                    <td class="text-center">{{list.term}}</td>
                    <td class="text-center">{{list.grading}}</td>
                    <td class="text-center">
                        <span v-if="list.is_active" class="badge bg-success">Active</span>
                        <span v-else class="badge bg-danger">Inactive</span>
                    </td>
                    <td class="text-end">
                        <Link :href="`/schools/${list.code}`">
                            <button class="btn btn-soft-dark btn-sm" type="button">
                                <div class="btn-content"> View </div>
                            </button>
                        </Link>
                        <!-- <b-button variant="soft-primary" v-b-tooltip.hover title="Edit" size="sm" class="edit-list"><i class="ri-pencil-fill align-bottom"></i> </b-button> -->
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
</template>
<script>
import Multiselect from '@suadelabs/vue3-multiselect';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    props: ['regions'],
    components: { Pagination, Multiselect },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            provinces: [],
            municipalities: [],
            keyword: '',
            region: null,
            municipality: null,
            province: null
        }
    },
    created() {
        this.fetch();
    },
    watch: {
        keyword(newVal){
            this.checkSearchStr(newVal)
        },
        region(){
            this.province = null;
            this.municipality = null;
            this.fetchProvince(this.region.code);
            this.fetch();
        },
        province(){
            this.municipality = null;
            this.fetchMunicipality(this.province.code);
            this.fetch();
        },
        municipality(){
            this.fetch();
        }
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url) {
            page_url = page_url || '/schools';
            axios.get(page_url, {
                params: {
                    keyword: this.keyword,
                    region: (this.region) ? this.region.code : '',
                    province: (this.province) ? this.province.code : '',
                    municipality: (this.municipality) ? this.municipality.code : '',
                    counts: ((window.innerHeight-410)/56),
                    type: 'lists'
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err));
        },
        message(data){
            let index = this.lists.findIndex(u => u.id === data.id);
            this.lists[index] = data;
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
    }
}
</script>
<style>
.multiselect__single { 
    font-size: 13px;
}
</style>
