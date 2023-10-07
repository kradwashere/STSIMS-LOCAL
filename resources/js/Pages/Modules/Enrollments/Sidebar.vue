<template>
    <div class="p-4 d-flex flex-column h-100">
        <form class="app-search d-none d-md-block" style="margin-top: -25px;">
            <div class="position-relative">
                <input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search-options" />
                <span class="mdi mdi-magnify search-widget-icon"></span>
                <span @click="scholar = null" class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
            </div>
            <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                <SimpleBar data-simplebar style="max-height: height: calc(100vh/2 - 326px)">
                    <div class="notification-list">
                        <b-link @click="choose(list)" v-for="(list, index) of names" :key="index" class="d-flex dropdown-item notify-item py-2">
                            <img :src="currentUrl+'/images/avatars/'+list.profile.avatar" class="me-3 rounded-circle avatar-xs" alt="user-pic" />
                            <div class="flex-1">
                                <h6 class="m-0">{{ list.profile.name}}</h6>
                                <span class="fs-11 mb-0 text-muted">{{list.program.name}}</span>
                            </div>
                        </b-link>
                    </div>
                </SimpleBar>
            </div>
        </form>
        <div class="alert alert-secondary mt-n2" v-if="!scholar" role="alert">Search scholar to enroll. Using name or SPAS Id</div>
        <ul class="list-unstyled mb-0 vstack gap-3" v-else>
            <li>
                <hr class="mt-0" />
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img :src="currentUrl+'/images/avatars/'+scholar.profile.avatar" alt="" class="avatar-sm rounded">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="fs-14 mb-1 text-primary">{{scholar.profile.name}}</h6>
                        <span :class="'badge bg-secondary bg-'+scholar.status.color">{{scholar.status.name}}</span>
                    </div>
                </div>
            </li>
            <li><i @click="viewProspectus()" style="font-size: 70px; top: 130px; right: 15px; position: absolute;" class="ri-todo-fill text-light"></i><i class="mdi mdi-seal-variant me-2 align-middle text-primary fs-16"></i><span class="fs-12">{{scholar.program.name}}</span></li>
            <li class="mt-n3"><i class="ri-building-line me-2 align-middle text-primary fs-16"></i><span class="fs-12">{{scholar.education.school.name}}</span></li>
            <li class="mt-n3"><i class="mdi mdi-school-outline me-2 align-middle text-primary fs-16"></i><span class="fs-12">{{scholar.education.course.name}}</span></li>
            <li v-if="scholar.education.school.semester">
                <div v-if="!scholar.education.school.is_enrolled" class="alert alert-warning alert-dismissible alert-label-icon rounded-label" role="alert">
                    <i class="ri-alert-line label-icon"></i>Scholar is not Enrolled 
                    <button @click="viewEnroll()" class="btn btn-primary btn-sm float-end" style="margin-right: -40px; margin-top: -3px;" type="button"><div class="btn-content"> Enroll now</div></button>
                </div>
                <div v-else class="alert alert-secondary alert-dismissible alert-label-icon rounded-label" role="alert">
                    <i class="ri-check-double-line label-icon"></i>Scholar is currently enrolled 
                </div>
            </li>
            <li v-else>
                <div class="alert alert-danger alert-dismissible alert-label-icon rounded-label" v-b-tooltip.hover title="Please remind the coordinator" role="alert">
                    <i class="ri-error-warning-line label-icon"></i>Enrollment is still closed.
                </div>
            </li>
            <li>
                <div data-simplebar style="height: calc(100vh - 530px);" class="mt-n2">
                    <ul class="list-group mb-1">
                        <li class="list-group-item" v-for="list in scholar.enrollments" v-bind:key="list.id">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <i v-if="list.is_locked" v-b-tooltip.hover title="Enrollment already locked." class="ri-lock-2-fill float-end fs-24 text-light align-middle me-2"></i>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title bg-soft-danger text-danger rounded">
                                                <i class=" bx bxs-file-pdf "></i>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ms-2" @click="fetchLists(list)" style="cursor: pointer;">
                                            <h6 class="fs-13 mb-0"> {{ list.academic_year }}
                                                <span class="text-muted"> / </span>
                                                <span class="text-info">{{ list.level }}</span>
                                                <span class="text-muted"> / </span>
                                                <span class="text-warning">{{ list.semester }}</span></h6>
                                            <small class="text-muted">{{ list.created_at}}</small>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <Course ref="course"/>
</template>
<script>
import Course from './Modals/Course.vue';
import { SimpleBar } from "simplebar-vue3";
export default {
    components: { SimpleBar, Course },
    data(){
        return {
            currentUrl: window.location.origin,
            names: [],
            scholar: null,
            show: null
        }
    },
    mounted() {
        this.isCustomDropdown();
    },
    watch: {
        data: {
            deep: true,
            handler(val = null) {
                if(val != null && val !== ''){
                    this.message(val.data);
                }
            },
        },
    },
    computed: {
        data() {
            return this.$page.props.flash.data;
        },
    },
    methods: {
        checkSearchStr: _.debounce(function (string) {
            this.keyword = string;
            this.search();
        }, 1000),
        search(){
            axios.get('/scholars', {
                params: {
                    keyword: this.keyword,
                    type: 'search'
                }
            })
            .then(response => {
                if(response){ this.names = response.data.data; }
            })
            .catch(err => console.log(err));
        },
        choose(data){
            this.scholar = data;
            if (this.scholar.education.subcourse == null) {
                this.$refs.course.set(
                    this.scholar.id, 
                    this.scholar.profile, 
                    this.scholar.education.school, 
                    this.scholar.education.course
                );
                this.show = 'course';
            }else{
                if(this.show != 'enroll'){
                    this.viewProspectus();
                }
            }
        },
        viewProspectus(){
            this.$parent.prospectus('prospectus',this.scholar.education.info);
        },
        viewEnroll(){
            this.show = 'enroll';
            this.$parent.enroll('enroll',this.scholar);
        },
        fetchLists(list){
            this.$parent.assessment('assessment',list,this.scholar);
        },
        message(list) {
            switch(this.show){
                case 'enroll':
                    this.choose(list);
                    this.fetchLists(this.scholar.enrollments[0]);
                    this.show = 'assessment';
                break;
                case 'course':
                    this.choose(list);
                break;
            }
        },
        isCustomDropdown() {
            var searchOptions = document.getElementById("search-close-options");
            var dropdown = document.getElementById("search-dropdown");
            var searchInput = document.getElementById("search-options");

            searchInput.addEventListener("focus", () => {
                var inputLength = searchInput.value.length;
                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchInput.addEventListener("keyup", () => {
                var inputLength = searchInput.value.length;
                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");
                    this.checkSearchStr(searchInput.value);
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchOptions.addEventListener("click", () => {
                searchInput.value = "";
                dropdown.classList.remove("show");
                searchOptions.classList.add("d-none");
            });

            document.body.addEventListener("click", (e) => {
                if (e.target.getAttribute("id") !== "search-options") {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });
        }
    }
}
</script>
<style>
    .dropdown-menu-lg {
        width: 89%;
    }
</style>