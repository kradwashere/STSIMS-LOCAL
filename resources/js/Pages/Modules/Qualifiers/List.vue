<template>
    <b-row class="g-2 mb-2 mt-n1">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search Qualifier" class="form-control" style="width: 30%;">
                <select v-model="filter.program" @change="fetch()" class="form-select" id="inputGroupSelect01" style="width: 120px;">
                    <option :value="null" selected>Select Program</option>
                    <option :value="list.id" v-for="list in listprograms" v-bind:key="list.id">{{list.name}}</option>
                </select>
                 <select v-model="filter.subprogram" @change="fetch()" class="form-select" id="inputGroupSelect01" style="width: 120px;">
                    <option :value="null" selected>Select Subprogram</option>
                    <option :value="list.id" v-for="list in listsubprograms" v-bind:key="list.id">{{list.name}}</option>
                </select>
                <select v-model="filter.type" @change="fetch()" class="form-select" id="inputGroupSelect01" style="width: 120px;">
                    <option :value="null" selected>Select Type</option>
                    <option :value="list.id" v-for="list in listtypes" v-bind:key="list.id">{{list.name}}</option>
                </select>
                <select v-model="filter.status" @change="fetch()" class="form-select" id="inputGroupSelect02" style="width: 120px;">
                    <option :value="null" selected>Select Status</option>
                    <option :value="list.id" v-for="list in liststatuses" v-bind:key="list.id">{{list.name}}</option>
                </select>
                <input type="text" v-model="filter.year" placeholder="Year Awarded" class="form-control" style="width: 100px;">
                <span @click="refresh" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                    <i class="bx bx-refresh search-icon"></i>
                </span>
                <b-button type="button" variant="primary" @click="showFilter()">
                    <i class="ri-filter-fill align-bottom me-1"></i> Filter
                </b-button>
            </div>
        </b-col>
    </b-row>
    <div class="table-responsive">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th></th>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 15%;" class="text-center">Address</th>
                    <th style="width: 15%;" class="text-center">Program</th>
                    <th style="width: 15%;" class="text-center">Type</th>
                    <th style="width: 15%;" class="text-center">Awarded Year</th>
                    <th style="width: 15%;" class="text-center">Status</th>
                    <th style="width: 10%;"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(list,index) in lists" v-bind:key="list.id" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                    <td>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle">{{list.profile.lastname.charAt(0)}}</span>
                    </div>
                </td>
                <td>
                    <h5 class="fs-13 mb-0 text-dark">{{list.profile.lastname}}, {{list.profile.firstname}} {{list.profile.middlename[0]}}.</h5>
                    <p class="fs-11 text-muted mb-0">{{list.spas_id }}</p>
                </td>
                <!-- <td class="text-center fs-12">
                    {{list.address.hs_school}}
                </td> -->
                    <td class="text-center">
                    <h5 class="fs-11 mb-0 text-dark">{{list.address.name}}</h5>
                    <p class="fs-11 text-muted mb-0">
                        {{(list.address.province) ? list.address.province.name+',' : ''}}
                        {{(list.address.region) ? list.address.region.region : ''}}
                    </p>
                </td>
                <td class="text-center">
                    <h5 class="fs-12 mb-0 text-dark">{{list.program.name}}</h5>
                    <p class="fs-11 text-muted mb-0">{{list.subprogram.name }}</p>
                </td>
                <td class="text-center">
                    <span :class="'badge '+list.status.color+' '+list.status.others">{{list.status.name}}</span>
                </td>
                <td class="text-center">{{list.qualified_year}}</td>
                    <td class="text-center">
                    <span :class="'badge '+list.type.color+' '+list.type.others">{{list.type.name}}</span>
                </td>
                <td class="text-end">
                    <b-button v-if="list.address.is_completed != 0 && list.status.name != 'Complete' && list.type.name != 'Enrolled'" variant="soft-primary" @click="showEndorse(list,'endorse',index)" v-b-tooltip.hover title="Endorse" size="sm" class="edit-list me-1"><i class="ri-swap-fill align-bottom"></i> </b-button>
                    <b-button v-if="list.address.is_completed != 0 && list.type.name != 'Enrolled'" @click="showAdd(list,'add',index)" variant="soft-primary" v-b-tooltip.hover title="Add Scholar" size="sm" class="edit-list me-1"><i class="ri-user-add-fill align-bottom"></i> </b-button>
                    <b-button v-if="list.address.is_completed == 0" @click="showUpdate(list,'update',index)" variant="soft-danger" v-b-tooltip.hover title="Update Address" size="sm" class="remove-list me-1"><i class="ri-map-pin-fill align-bottom"></i></b-button>
                    <!-- <b-button variant="soft-primary" v-b-tooltip.hover title="Edit" size="sm" class="edit-list"><i class="ri-pencil-fill align-bottom"></i> </b-button> -->
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="extractPageNumber" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
    <Add ref="add"/>
    <Endorse ref="endorse"/>
    <ViewEndorse ref="viewendorse"/>
    <Update ref="update" :dropdowns="dropdowns"/>
</template>
<script>
import Add from './Modals/Add.vue';
import Update from './Modals/Update.vue';
import Endorse from './Modals/Endorse';
import ViewEndorse from './Modals/ViewEndorse.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, Add, Endorse, ViewEndorse, Update },
    props : ['regions', 'programs', 'dropdowns', 'statuses'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                subfilters: [],
                program: null,
                subprogram: null,
                status: null,
                type: null,
                year: null,
                keyword: null,
                sort: 'asc'
            },
            subfilters: [],
            flag: '',
            index: '',
            pageNo: null,
        }
    },
    computed: {
        listprograms : function() {
            return this.programs.filter(x => x.is_sub === 1);
        },
        listsubprograms() {
            return this.programs;
        },
        listtypes : function() {
            return this.statuses.filter(x => x.type === 'Qualifier');
        },
        liststatuses : function() {
            return this.statuses.filter(x => x.type === 'Qualifier Status');
        },
        data() {
            return this.$page.props.flash.data;
        },
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
        "filter.year"(newVal){
            this.checkSearchStr(newVal)
        },
        data: {
            deep: true,
            handler(val = null) {
                if(val != null && val !== ''){
                    if(this.flag == 'endorse'){
                        this.lists[this.index].is_endorsed = 1;
                    }else if(this.flag == 'add'){
                        this.lists[this.index].type = val.type;
                    }else{
                        this.lists[this.index] = val;
                    }
                }
            },
        },
    },
    created(){
        this.fetch();
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url) {
            let info = {
                'keyword': this.filter.keyword,
                'status': (this.filter.status == null) ? null : this.filter.status,
                'program': (this.filter.program == null) ? null : this.filter.program,
                'subprogram': (this.filter.subprogram == null) ? null : this.filter.subprogram,
                'category': (this.filter.category == null) ? null : this.filter.category,
                'type': (this.filter.type == null) ? null : this.filter.type,
                'year': (this.filter.year === '' || this.filter.year == null) ? '' : this.filter.year,
                'counts': parseInt(((window.innerHeight-350)/56)),
                'sort': this.filter.sort
            };

            info = (Object.keys(info).length == 0) ? '-' : JSON.stringify(info);
            this.subfilters = (Object.keys(this.subfilters).length == 0) ? '-' : JSON.stringify(this.subfilters);

            page_url = page_url || '/qualifiers';
            axios.get(page_url, {
                params: {
                    info: info,
                    subfilters: this.subfilters,
                    type: 'lists',
                    page: this.pageNo
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err));
        },
        subfilter(list){
            this.subfilters = list;
            this.fetch();
        },
        showFilter(){
            this.$refs.filter.show();
        },
        showUpdate(data,type,index){
            this.index = index;
            this.flag = type;
            this.$refs.update.show(data,type);
        },
        showEndorse(data,type,index){
            this.index = index;
            this.flag = type;
            this.$refs.endorse.show(data);
        },
        showAdd(data,type,index){
            this.index = index;
            this.flag = type;
            this.$refs.add.show(data);
        },
        refresh(){
            this.filter = {
                category: null,
                program: null,
                status: null,
                year: null,
                type: null,
                keyword: null,
                sort: 'asc'
            };
        },
        extractPageNumber(page_url) {
            this.pageNo = null;
            const nextUrl = page_url;
            const regex = /page=(\d+)/;
            const match = nextUrl.match(regex);

            if (match) {
                this.pageNo = match[1];
            } else {
                this.pageNo = null;
            }
            this.fetch();
        },
    }
}
</script>