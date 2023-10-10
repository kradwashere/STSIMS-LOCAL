<template>
    <h6 class="fs-11 text-muted text-uppercase mb-3">Ongoing Scholars</h6>
    <div class="d-flex align-items-center">
        <div class="flex-shrink-0">
            <i class="ri-team-fill text-dark fs-17"></i>
        </div>
        <div class="flex-grow-1 ms-3 overflow-hidden">
            <div class="progress mb-2 progress-sm">
                <div class="progress-bar bg-dark" role="progressbar" :style="'width: '+(counts.scholars/counts.total)*100+'%'" :aria-valuenow="(counts.enrolled.length/counts.scholars)*100"
                aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <span class="text-muted fs-12 d-block text-truncate"><b>{{counts.scholars}}</b> out of <b>{{counts.total}}</b> are ongoing scholars.</span>
        </div>
    </div>

    <hr class="text-muted"/>

    <h6 class="fs-11 text-muted text-uppercase mb-3">Scholars Enrolled</h6>
    <div class="d-flex align-items-center">
        <div class="flex-shrink-0">
            <i class="ri-group-2-fill text-dark fs-17"></i>
        </div>
        <div class="flex-grow-1 ms-3 overflow-hidden">
            <div class="progress mb-2 progress-sm">
                <div class="progress-bar bg-dark" role="progressbar" :style="'width: '+(counts.enrolled/counts.scholars)*100+'%'" :aria-valuenow="(counts.enrolled.length/counts.scholars)*100"
                aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <span class="text-muted fs-12 d-block text-truncate"><b>{{counts.enrolled}}</b> out of <b>{{counts.scholars}}</b> ongoing scholars are enrolled.</span>
        </div>
    </div>

    <hr class="text-muted"/>

    <h6 class="fs-11 text-muted text-uppercase mb-3">Schools Semester for {{semester_year}} </h6>
    <div class="d-flex align-items-center">
        <div class="flex-shrink-0">
            <i class="ri-hotel-line text-dark fs-17"></i>
        </div>
        <div class="flex-grow-1 ms-3 overflow-hidden">
            <div class="progress mb-2 progress-sm">
                <div class="progress-bar bg-dark" role="progressbar" :style="'width: '+(counts.semesters.length/counts.schools)*100+'%'" :aria-valuenow="(counts.semesters.length/counts.schools)*100"
                aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <span class="text-muted fs-12 d-block text-truncate"><b>{{counts.semesters.length}}</b> out of <b>{{counts.schools}}</b> schools with active semester.</span>
        </div>
    </div>

    <hr class="text-muted"/>

    <div class="mt-2">
        <ul class="list-unstyled vstack gap-3" style="cursor:pointer;">
            <li>
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar-xs">
                            <div class="avatar-title rounded bg-soft-primary text-primary">
                            <i class="bx bxs-graduation fs-17"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-0 fs-13">Graduating Scholars</h5>
                        <p class="mb-0 fs-12 text-muted">Qualified for graduation</p>
                    </div>
                    <div class="avatar-group">
                        <div class="avatar-group-item" v-for="user in scholarsGraduating" v-bind:key="user.id">
                            <a class="d-inline-block" v-b-tooltip.hover :title="user.firstname+' '+user.lastname">
                                <img :src="currentUrl+'/images/avatars/'+user.avatar" alt="" class="rounded-circle avatar-xxs">
                            </a>
                        </div>
                        <div class="avatar-group-item" v-if="counts.graduating.length > 0"> 
                            <a class="" href="javascript: void(0);" target="_self" v-b-tooltip.hover :title="counts.graduating.length +' more scholars'">
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
                            <a class="" href="javascript: void(0);" target="_self" v-b-tooltip.hover :title="counts.grades.length +' more scholars'">
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
                            <a class="" href="javascript: void(0);" target="_self" v-b-tooltip.hover :title="counts.benefits.length +' more scholars'">
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
                            <div class="avatar-title rounded bg-soft-info text-info">
                            <i class="ri-question-fill fs-17"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-0 fs-13">Unenrolled Scholars</h5>
                        <p class="mb-0 fs-12 text-muted">No enrolled in current active semester</p>
                    </div>
                    <div class="avatar-group">
                        <div class="avatar-group-item" v-for="user in scholarsUnenrolled" v-bind:key="user.id">
                            <a class="d-inline-block" v-b-tooltip.hover :title="user.firstname+' '+user.lastname">
                                <img :src="currentUrl+'/images/avatars/'+user.avatar" alt="" class="rounded-circle avatar-xxs">
                            </a>
                        </div>
                        <div class="avatar-group-item" v-if="counts.unenrolled.length > 0"> 
                            <a class="" href="javascript: void(0);" target="_self" v-b-tooltip.hover :title="counts.unenrolled.length+' more scholars'">
                                <div class="avatar-xxs">
                                    <span class="avatar-title rounded-circle bg-success text-white">+ {{}}</span>
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
                            <i class="ri-alert-fill fs-17"></i>
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
                        <div class="avatar-group-item" v-if="counts.missed.length > 0"> 
                            <a class="" href="javascript: void(0);" target="_self" v-b-tooltip.hover :title="counts.missed.length +' more scholars'">
                                <div class="avatar-xxs">
                                    <span class="avatar-title rounded-circle bg-success text-white">+</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
             <li @click="termination(scholarsTermination)"> 
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
                            <a class="d-inline-block" v-b-tooltip.hover :title="user.scholar.firstname+' '+user.scholar.lastname">
                                <img :src="currentUrl+'/images/avatars/'+user.scholar.avatar" alt="" class="rounded-circle avatar-xxs">
                            </a>
                        </div>
                        <div class="avatar-group-item" v-if="counts.termination.length > 0"> 
                            <a class="" href="javascript: void(0);" target="_self" v-b-tooltip.hover :title="counts.termination.length +' more scholars'">
                                <div class="avatar-xxs">
                                    <span class="avatar-title rounded-circle bg-info text-white">+</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <Termination ref="termination" />
</template>
<script>
import Termination from './Modals/Sub/Termination.vue';
export default {
    components : { Termination },
    props: ['semester_year'],
    data(){
        return {
            currentUrl: window.location.origin,
            counts: { semesters: [], enrolled: [], benefits: [] , grades: [], termination: [], missed: [], graduating: [], unenrolled: []},
        }
    },
    created(){
        this.fetch();
    },
    computed: {
        scholarsBenefits: function () {
            return (this.counts.benefits.length > 0) ? this.counts.benefits.splice(0,3) : [];
        },
        scholarsMissed: function () {
            return (this.counts.missed.length > 0) ? this.counts.missed.splice(0,3) : [];
        },
        scholarsUnenrolled: function () {
            return (this.counts.unenrolled.length > 0) ? this.counts.unenrolled.splice(0,3) : [];
        },
        scholarsGrades: function () {
            return (this.counts.grades.length > 0) ? this.counts.grades.splice(0,3) : [];
        },
        scholarsTermination: function () {
            return (this.counts.termination.length > 0) ? this.counts.termination.splice(0,3) : [];
        },
        scholarsGraduating: function () {
            return (this.counts.graduating.length > 0) ? this.counts.graduating.splice(0,3) : [];
        }
    },
    methods: {
        fetch(){
            axios.get(this.currentUrl+'/monitoring', {
                params: {
                    type: 'counts',
                    semester_year: this.semester_year
                }
            })
            .then(response => {
                this.counts = response.data;
            })
            .catch(err => console.log(err));
        },
        termination(data){
            if(data.length > 0){
                this.$refs.termination.show(data);
            }
        }
    }
}
</script>