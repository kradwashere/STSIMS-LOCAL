<template>
    <b-row>
        <b-col lg="4">
            <b-card>
                <b-card-body style="height: calc(100vh - 355px)">
                    <b-card no-body class="mb-1 ribbon-box ribbon-fill ribbon-sm">
                        <div class="ribbon ribbon-success"><i class="ri-flashlight-fill"></i></div>
                        <b-card-body>
                            <b-link class="d-flex align-items-center" role="button" v-b-toggle.contactInitiated1>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">{{semester.academic_year}}</h6>
                                    <p class="text-muted mb-0">{{semester.start_at}} - {{semester.end_at}}</p>
                                </div>
                            </b-link>
                        </b-card-body>
                    </b-card>
                     <hr class="text-muted"/>

                    <h6 class="fs-11 text-muted text-uppercase mb-3">Scholars Enrolled</h6>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ri-group-2-fill text-dark fs-17"></i>
                        </div>
                        <div class="flex-grow-1 ms-3 overflow-hidden">
                            <div class="progress mb-2 progress-sm">
                                <div class="progress-bar bg-dark" role="progressbar" :style="'width: '+(counts.enrolled.length/counts.scholars)*100+'%'" :aria-valuenow="(counts.enrolled.length/counts.scholars)*100"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-muted fs-12 d-block text-truncate"><b>{{counts.enrolled}}</b> out of <b>{{counts.scholars}}</b> ongoing scholars are enrolled in this semester.</span>
                        </div>
                    </div>

                    <hr class="text-muted"/>

                    <ul class="list-unstyled vstack gap-3">
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs">
                                        <div class="avatar-title rounded bg-soft-secondary text-secondary">
                                        <i class="ri-file-text-line fs-17"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0 fs-13">Lacking Grades</h5>
                                    <p class="mb-0 fs-12 text-muted">No Grades in an inactive semester</p>
                                </div>
                                <div class="avatar-group">
                                    <div class="avatar-group-item" v-for="user in scholarsGrades" v-bind:key="user.id">
                                        <a class="d-inline-block" v-b-tooltip.hover :title="user.firstname+' '+user.lastname">
                                            <img :src="currentUrl+'/images/avatars/'+user.avatar" alt="" class="rounded-circle avatar-xxs">
                                        </a>
                                    </div>
                                    <div class="avatar-group-item" v-if="counts.grades.length > 0"> 
                                        <a class="" href="javascript: void(0);" target="_self" v-b-tooltip.hover :title="counts.grades.length - 3 +' more scholars'">
                                            <div class="avatar-xxs">
                                                <span class="avatar-title rounded-circle bg-info text-white">+</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs">
                                        <div class="avatar-title rounded bg-soft-success text-success">
                                        <i class="ri-wallet-line fs-17"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0 fs-13">Unreleased Benefits</h5>
                                    <p class="mb-0 fs-12 text-muted">Stipend not released</p>
                                </div>
                                <div class="avatar-group">
                                    <div class="avatar-group-item" v-for="user in scholarsBenefits" v-bind:key="user.id">
                                        <a class="d-inline-block" v-b-tooltip.hover :title="user.firstname+' '+user.lastname">
                                            <img :src="currentUrl+'/images/avatars/'+user.avatar" alt="" class="rounded-circle avatar-xxs">
                                        </a>
                                    </div>
                                    <div class="avatar-group-item" v-if="counts.benefits.length > 0"> 
                                        <a class="" href="javascript: void(0);" target="_self" v-b-tooltip.hover :title="counts.benefits.length - 3 +' more scholars'">
                                            <div class="avatar-xxs">
                                                <span class="avatar-title rounded-circle bg-success text-white">+</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs">
                                        <div class="avatar-title rounded bg-soft-warning text-warning">
                                        <i class="ri-question-fill fs-17"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0 fs-13">Missed Enrollment</h5>
                                    <p class="mb-0 fs-12 text-muted">No COR submitted</p>
                                </div>
                                <div class="avatar-group">
                                    <div class="avatar-group-item" v-for="user in scholarsMissed" v-bind:key="user.id">
                                        <a class="d-inline-block" v-b-tooltip.hover :title="user.firstname+' '+user.lastname">
                                            <img :src="currentUrl+'/images/avatars/'+user.avatar" alt="" class="rounded-circle avatar-xxs">
                                        </a>
                                    </div>
                                    <div class="avatar-group-item" v-if="counts.termination.length > 0"> 
                                        <a class="" href="javascript: void(0);" target="_self" v-b-tooltip.hover :title="counts.termination.length - 3 +' more scholars'">
                                            <div class="avatar-xxs">
                                                <span class="avatar-title rounded-circle bg-info text-white">+</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs">
                                        <div class="avatar-title rounded bg-soft-danger text-danger">
                                        <i class="ri-error-warning-line fs-17"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0 fs-13">For Termination</h5>
                                    <p class="mb-0 fs-12 text-muted">2 Grades Failed in a semester</p>
                                </div>
                                <div class="avatar-group">
                                    <div class="avatar-group-item" v-for="user in scholarsTermination" v-bind:key="user.id">
                                        <a class="d-inline-block" v-b-tooltip.hover :title="user.firstname+' '+user.lastname">
                                            <img :src="currentUrl+'/images/avatars/'+user.avatar" alt="" class="rounded-circle avatar-xxs">
                                        </a>
                                    </div>
                                    <div class="avatar-group-item" v-if="counts.termination.length > 0"> 
                                        <a class="" href="javascript: void(0);" target="_self" v-b-tooltip.hover :title="counts.termination.length - 3 +' more scholars'">
                                            <div class="avatar-xxs">
                                                <span class="avatar-title rounded-circle bg-info text-white">+</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </b-card-body>
            </b-card>
        </b-col>
        <b-col lg="8">

            <div class="card" id="contactList">
                <div class="card-header">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="search-box"><input type="text" class="form-control search" placeholder="Search for semester">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-md-auto ms-auto">
                            <div class="d-flex align-items-center gap-2">
                                <button @click="newModal" class="btn btn-danger btn-md add-btn" type="button">
                                    <div class="btn-content">New Semester</div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="height: calc(100vh - 392px)">
                    <div>
                        <div class="table-responsive mb-3">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead class="table-light fs-12">
                                    <tr>
                                        <th>Academic Year</th>
                                        <th class="text-center">Start at</th>
                                        <th class="text-center">End at</th>
                                        <th class="text-center">Semester</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-end"></th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <tr v-for="list in lists" v-bind:key="list.id">
                                        <td class="fs-14 fw-medium">{{list.academic_year}}</td>
                                        <td class="text-center">{{list.start_at}}</td>
                                        <td class="text-center">{{list.end_at}}</td>
                                        <td class="text-center">{{list.semester.name}}</td>
                                        <td class="text-center">
                                            <span v-if="list.is_active" class="badge bg-success">Active</span>
                                            <span v-else class="badge bg-danger">Inactive</span>
                                        </td>
                                        <td class="text-end">
                                            <b-button variant="soft-primary" v-b-tooltip.hover title="Edit" size="sm" class="edit-list"><i class="ri-pencil-fill align-bottom"></i> </b-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                             <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                        </div>
                        
                    </div>
                </div>
            </div>
        </b-col>
    </b-row>
    <Semester :semesters="semesters" @status="message" ref="new"/>
</template>
<script>
import Pagination from "@/Shared/Components/Pagination.vue";
import Semester from './Modals/Semester.vue';
export default {
    components: { Semester, Pagination },
    props: ['dropdowns','id','term'],
    data(){
        return{
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            semester: {},
            counts: { enrolled: 0, scholars: 0, semesters: [], missed: [], benefits: [] , grades: [], termination: []},
        }
    },    
    computed : {
        semesters : function() {
            return this.dropdowns.filter(x => x.classification === this.term);
        },
        scholarsBenefits: function () {
            return (this.counts.benefits.length > 0) ? this.counts.benefits.splice(0,3) : [];
        },
        scholarsGrades: function () {
            return (this.counts.grades.length > 0) ? this.counts.grades.splice(0,3) : [];
        },
        scholarsTermination: function () {
            return (this.counts.termination.length > 0) ? this.counts.termination.splice(0,3) : [];
        },
        scholarsMissed: function () {
            return (this.counts.missed.length > 0) ? this.counts.missed.splice(0,3) : [];
        }
    },
    created(){
        this.fetch();
        this.fetchSemester();
    },
    methods : {
        newModal(){
            this.$refs.new.show(this.id);
        },
        fetch(page_url){
            page_url = page_url || '/schools';
            axios.get(page_url,{
                params : {
                    id: this.id,
                    type: 'semesters',
                    keyword : this.keyword,
                    counts: ((window.innerHeight-500)/51)
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;                    
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                }
            })
            .catch(err => console.log(err));
        },
        fetchSemester(){
            axios.get(this.currentUrl+'/schools',{
                params : {
                    id: this.id,
                    type: 'activesemester'
                }
            })
            .then(response => {
                if(response){
                    this.semester = response.data.active; 
                    (this.semester) ? this.monitoring() : '';  
                }
            })
            .catch(err => console.log(err));
        },
        monitoring(){
            axios.get(this.currentUrl+'/monitoring', {
                params: {
                    type: 'counts',
                    semester_id: this.semester.id
                }
            })
            .then(response => {
                this.counts = response.data;
            })
            .catch(err => console.log(err));
        },
        message(){
            this.fetch();
            this.fetchSemester();
        }
    }
}
</script>
