<template>
    <b-col lg="4">
        <b-card>
            <b-card-body style="height: calc(100vh - 320px)">
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
                <hr class="text-muted mt-4"/>
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

                <hr class="text-muted mb-4"/>

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
</template>
<script>
export default {
    props: ['id'],
    data(){
        return {
            currentUrl: window.location.origin,
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
        this.fetchSemester();
    },
    methods: {
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
    }
}
</script>