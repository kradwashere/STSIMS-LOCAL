<template>
    <b-row class="g-2 mb-2 mt-n1">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search scholar" class="form-control" style="width: 30%;">
                <select v-model="filter.program" @change="fetch()" class="form-select" id="inputGroupSelect01" style="width: 120px;">
                    <option :value="null" selected>Select Program</option>
                    <option :value="list.id" v-for="list in program_list" v-bind:key="list.id">{{list.name}}</option>
                </select>
                <select v-model="filter.type" @change="fetch()" class="form-select" id="inputGroupSelect01" style="width: 120px;">
                    <option :value="null" selected>Select Type</option>
                    <option value="1">Undergraduate</option>
                    <option value="0">JLSS</option>
                </select>
                <select v-model="filter.status" @change="fetch()" class="form-select" id="inputGroupSelect02" style="width: 120px;">
                    <option :value="null" selected>Select Status</option>
                    <option :value="list.id" v-for="list in status_list" v-bind:key="list.id">{{list.name}}</option>
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
                    <th style="width: 15%;" class="text-center">School</th>
                    <th style="width: 15%;" class="text-center">Program</th>
                    <th style="width: 15%;" class="text-center">Awarded Year</th>
                    <th style="width: 15%;" class="text-center">Status</th>
                    <th style="width: 10%;"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user,index) in lists" v-bind:key="index" :class="[(user.is_completed == 0) ? 'table-warnings' : '']">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                <img :src="currentUrl+'/images/avatars/'+user.profile.avatar" class="rounded-circle avatar-xs" alt="">
                                <span class="user-status" :style="(user.profile.sex == 'Male') ? 'background-color: #5cb0e5;' : 'background-color: #e55c7f;'"></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <h5 class="fs-13 mb-0 text-dark">{{user.profile.name}}</h5>
                        <p class="fs-12 text-muted mb-0">{{user.spas_id}} / {{user.account_no}}</p>
                    </td>
                    <td class="text-center">
                        <p class="fs-12 mb-n1 text-dark">{{(user.education.school instanceof Object) ? user.education.school.name : user.education.school}}</p>
                        <p class="fs-12 text-muted mb-0">{{(user.education.course instanceof Object) ? user.education.course.name : user.education.course}}</p>
                    </td>
                    <td class="text-center">{{user.program}}</td>
                    <td class="text-center">{{user.awarded_year}}</td>
                    <td class="text-center">
                        <span :class="'badge '+user.status.color+' '+user.status.others">{{user.status.name}}</span>
                    </td>
                    <td class="text-end">
                        <b-button v-if="user.user == null" @click="authenticate(user)" variant="soft-primary" v-b-tooltip.hover title="Create Scholar Account" size="sm" class="edit-list me-1"><i class="ri-user-add-fill align-bottom"></i> </b-button>
                        <b-button @click="showUpdate(user,'status',index)" variant="soft-warning" v-b-tooltip.hover title="Update Status" size="sm" class="remove-list me-1"><i class="ri-heart-fill align-bottom"></i></b-button>
                        <b-button v-if="user.account_no == null && user.status.type == 'Ongoing'" @click="showUpdate(user,'scholar',index)" variant="soft-danger" v-b-tooltip.hover title="Update Account No." size="sm" class="remove-list me-1"><i class="ri-bank-card-2-fill align-bottom"></i></b-button>
                        <b-button v-if="user.education.is_completed == 0" @click="showUpdate(user,'education',index)" variant="soft-danger" v-b-tooltip.hover title="Update Education" size="sm" class="remove-list me-1"><i class="ri-hotel-fill align-bottom"></i></b-button>
                        <b-button v-if="user.addresses[0].is_completed == 0" @click="showUpdate(user,'address',index)" variant="soft-danger" v-b-tooltip.hover title="Update Address" size="sm" class="remove-list me-1"><i class="ri-map-pin-fill align-bottom"></i></b-button>
                        <Link v-if="user.is_completed == 1" :href="`/scholars/${user.code}`"><b-button variant="soft-info" v-b-tooltip.hover title="View" size="sm" class="remove-list me-1"><i class="ri-eye-fill align-bottom"></i></b-button></Link>
                        <!-- <b-button variant="soft-primary" v-b-tooltip.hover title="Edit" size="sm" class="edit-list"><i class="ri-pencil-fill align-bottom"></i> </b-button> -->
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
    <Update ref="update" :statuses="statuses" :dropdowns="dropdowns"/>
    <Filter :regions="regions" :programs="programs" @status="subfilter" ref="filter"/>
</template>
<script>
import Update from './Modals/Update.vue';
import Filter from './Modals/Filter.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, Filter, Update },
    props : ['regions', 'programs', 'dropdowns', 'statuses'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                subfilters: [],
                category: null,
                program: null,
                status: null,
                year: null,
                type: null,
                keyword: null,
                sort: 'asc'
            },
            subfilters: [],
            flag: '',
            index: ''
        }
    },
    computed: {
        program_list : function() {
            return this.programs.filter(x => x.is_sub === 1).filter(x => x.is_active === 1);
        },
        subprogram_list : function() {
            return this.programs; 
        },
        status_list : function() {
            return this.statuses.filter(x => x.type != 'Benefit Status');
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
                    switch(this.flag){
                        case 'address':
                            this.lists[this.index].addresses[0] = val.data;
                            this.$emit('info',true);
                        break;
                        case 'education':
                            this.lists[this.index].education = val.data;
                            this.$emit('info',true);
                        break;
                        case 'scholar':
                            this.lists[this.index].account_no = val.account_no;
                            this.$emit('info',true);
                        break;
                         case 'status':
                            this.lists[this.index].status = val.status;
                            this.$emit('info',true);
                        break;
                        default:
                            this.$emit('unsync',val);
                        break;
                    }
                    this.flag = '';
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

            page_url = page_url || '/scholars';
            axios.get(page_url, {
                params: {
                    info: info,
                    subfilters: this.subfilters,
                    type: 'lists',
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
            this.flag = type;
            this.index = index;
            this.$refs.update.show(data,type);
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
        }
    }
}
</script>