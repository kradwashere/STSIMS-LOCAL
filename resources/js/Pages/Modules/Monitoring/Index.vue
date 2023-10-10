<template>
    <Head title="Monitoring" />
    <PageHeader :title="title" :items="items" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-sidebar">
            <div class="p-4 d-flex flex-column h-100">
                <Sidebar :semester_year="semester_year"/>
            </div>
         </div>

        <div class="file-manager-content w-100 p-3 pb-0" style="height: calc(100vh - 180px)" ref="box">
            <div class="card p-4 border shadow-none mb-4 mt-0">
                <div class="row g-0 text-center mt-n4 mb-n4">
                    <div class="col-sm-4 col-6" v-for="(list,index) in checking" v-bind:key="index">
                        <div class="p-3 border border-dashed border-start-0">
                            <h5 class="mb-1"><span class="text-success ms-1 fs-12">{{list.completed}}</span><span class="fs-12"> / {{list.count}}</span></h5>
                            <p class="text-muted mb-0">{{list.name}}  <i class="ri-question-fill" style="cursor: pointer;"></i></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg">
                <div class="input-group mb-1">
                    <span class="input-group-text"><i class="ri-search-line search-icon"></i></span>
                    <input type="text" placeholder="Search Scholar" v-model="keyword" class="form-control" style="width: 30%;">
                    <span class="input-group-text" style="cursor: pointer;" v-b-tooltip.hover title="Refresh">
                        <i class="bx bx-refresh text-primary  search-icon"></i>
                    </span>
                    <button @click="showFilter()" class="btn btn-primary btn-md" type="button">
                        <div class="btn-content"><i class="ri-search-eye-line align-bottom me-1"></i> Filter </div>
                    </button>
                </div>
                 <ul class="treding-keywords list-inline mb-0 mt-2 fs-11">
                    <li class="list-inline-item text-danger fw-semibold"><i
                            class="ri-search-eye-line align-middle"></i> Filters:</li>
                    <li class="list-inline-item">
                        <b-link href="#">Design,</b-link>
                    </li>
                    <li class="list-inline-item">
                        <b-link href="#">Development,</b-link>
                    </li>
                    <li class="list-inline-item">
                        <b-link href="#">Manager,</b-link>
                    </li>
                    <li class="list-inline-item">
                        <b-link href="#">Senior</b-link>
                    </li>
                </ul>
            </div>
            <hr class="text-muted mb-0 mt-3"/>
            <div class="table-responsive">
                <table class="table table-nowrap align-middle">
                    <thead class="table-light fs-11">
                        <tr>
                            <th style="width: 1%;"></th>
                            <th style="width: 20%;">Name</th>
                            <th class="text-center" style="width: 15%;">Enrollment</th>
                            <th class="text-center" style="width: 15%;">Benefits</th>
                            <th class="text-center" style="width: 15%;">Status</th>
                            <th class="text-center" style="width: 18%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user,index) in lists" v-bind:key="index">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                        <img :src="currentUrl+'/images/avatars/'+user.profile.avatar" class="rounded-circle avatar-xs" alt="">
                                        <span class="user-status" :style="(user.profile.sex == 'Male') ? 'background-color: #5cb0e5;' : 'background-color: #e55c7f;'"></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5 class="fs-12 mb-0 text-dark">{{user.profile.name}}</h5>
                                <p class="fs-11 text-muted mb-0">{{user.spas_id}}</p>
                            </td>
                            <td class="text-center fs-12" style="cursor: default;">
                                <span>{{user.program}}</span>
                            </td>
                            <td class="text-center fs-12" style="cursor: default;">
                                <span v-b-tooltip.hover :title="user.education.school.name">{{user.education.school.shortcut}}</span>
                            </td>
                            <td class="text-center fs-11">
                                <span :class="'badge '+user.status.color+' '+user.status.others">{{user.status.name}}</span>
                            </td>
                            <td class="text-end">
                               <b-button @click="view(user)" variant="soft-primary" v-b-tooltip.hover title="View Scholar" size="sm" class="remove-list me-1"><i class="ri-eye-fill align-bottom"></i></b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetchScholars" :lists="lists.length" :links="links" :pagination="meta" />
            </div>
        </div>

        <div class="file-manager-sidebar">
            <div class="p-4 d-flex flex-column h-100">
                <Rightbar :statuses="statuses" :released="released"/>
            </div>
         </div>
    </div>
    <Filter :regions="regions" :programs="programs" @status="subfilter" ref="filter"/>
    <View ref="view"/>
</template>
<script>
import View from './Modals/View.vue';
import Filter from './Modals/Filter.vue';
import Sidebar from './Sidebar.vue';
import Rightbar from './Rightbar.vue';
import PageHeader from "@/Shared/Components/PageHeader.vue";
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { PageHeader, Pagination, Sidebar, Rightbar, Filter, View },
    props: ['semester_year','dropdowns','regions', 'programs', 'dropdowns', 'statuses'],
    data() {
        return {
            currentUrl: window.location.origin,
            title: "Monitoring",
            items: [{text: "Monitor", href: "/",},{text: "Dasboard",active: true,},],
            statuses: [],
            checking: [],
            released: 0,
            icons: ['ri-checkbox-circle-fill text-success','ri-question-line text-warning','ri-close-circle-fill text-danger','ri-error-warning-fill text-info'],
            lists: [],
            meta: {},
            links: {},
            status: null,
            keyword: ''
        };
    },
    created(){
        this.fetch();
        this.fetchScholars();
    },
     watch: {
        keyword(newVal){
            this.checkSearchStr(newVal)
        }
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetchScholars();
        }, 300),
        fetch(){
            axios.get(this.currentUrl+'/monitoring', {
                params: {
                    type: 'index'
                }
            })
            .then(response => {
                this.statuses = response.data.statuses;
                this.checking = response.data.checking;
                this.released = response.data.released;
            })
            .catch(err => console.log(err));
        },
        fetchScholars(page_url){
            page_url = page_url || '/monitoring';
            axios.get(page_url, {
                params: {
                    type: 'lists',
                    counts: ((window.innerHeight-450)/56),
                    status: this.status,
                    keyword: this.keyword
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err));
        },
        updateStatus(status){
            this.status = status;
            this.fetchScholars();
        },
        view(user){
            this.$refs.view.show(user);
        },
        filterEducation(){
            this.$refs.education.set();
        },
        firstLetters(originalText) {
            const wordsToRemove = ["IN", "AND", "OF"];
            const excludedWords = ["BS", "BSE"];
            const words = originalText.split(" ");
            const initials = words.map(word => excludedWords.includes(word) ? word : word.charAt(0));
            const filteredWords = initials.filter(word => !wordsToRemove.includes(word.toUpperCase()));
            return filteredWords.join("");
        },
        subfilter(list){
            this.subfilters = list;
            this.fetch();
        },
        showFilter(){
            this.$refs.filter.show();
        },
        view(user){
            this.$refs.view.show(user);
        }
    }
}
</script>
<style>
    .file-manager-sidebar {
        min-width: 450px;
        max-width: 450px;
        height: calc(100vh - 180px);
    }
</style>