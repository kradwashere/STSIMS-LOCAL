<template>
<Head :title="school.data.name" />
    <b-row>
        <b-col lg="12">
            <b-card no-body class="mt-n4 mx-n4">
                <div class="bg-soft-warning">
                    <b-card-body class="pb-0 px-4">
                        <b-row class="mb-3">
                            <b-col md>
                                <b-row class="align-items-center g-3">
                                    <b-col md="auto">
                                        <div class="avatar-md">
                                            <span v-if="school.data.avatar == 'school.jpg'"
                                                :class="'avatar-title rounded-circle bg-primary text-white fs-24'">{{school.data.name[0]}}</span>
                                            <img v-else :src="currentUrl+'/images/avatars/'+school.data.avatar" alt=""
                                                class="avatar-xs">
                                        </div>
                                    </b-col>
                                    <b-col md>
                                        <div>
                                            <h4 class="fw-bold">{{school.data.name}}</h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div><i class="ri-building-line align-bottom me-1"></i>
                                                    {{ school.data.campus }} Campus</div>
                                                <div class="vr"></div>
                                                <div><i class="ri-map-pin-2-fill align-bottom me-1"></i>
                                                    {{ school.data.address }}</div>
                                            </div>
                                        </div>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col md="auto">
                                <div class="hstack gap-1 flex-wrap">
                                    <!-- <button type="button" class="btn py-0 fs-16 favourite-btn active">
                                        <i class="ri-star-fill" @click="toggleFavourite"></i>
                                    </button> -->
                                    <Link href="/schools"><button type="button" class="btn py-0 fs-16 text-body">
                                        <i class="ri-share-line"></i>
                                    </button></Link>
                                    <!-- <button type="button" class="btn py-0 fs-16 text-body">
                                        <i class="ri-flag-line"></i>
                                    </button> -->
                                </div>
                            </b-col>
                        </b-row>

                        <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <b-link class="nav-link active fw-semibold" data-bs-toggle="tab" href="#overview" role="tab">
                                    Overview
                                </b-link>
                            </li>
                            <li class="nav-item">
                                <b-link class="nav-link fw-semibold" data-bs-toggle="tab" href="#semesters" role="tab">
                                    Semesters
                                </b-link>
                            </li>
                            <li class="nav-item">
                                <b-link class="nav-link fw-semibold" data-bs-toggle="tab" href="#courses" role="tab">
                                    Courses
                                </b-link>
                            </li>
                            <li class="nav-item">
                                <b-link class="nav-link fw-semibold" data-bs-toggle="tab" href="#grading" role="tab">
                                    Grading
                                </b-link>
                            </li>
                        </ul>
                    </b-card-body>
                </div>
            </b-card>
        </b-col>
    </b-row>
    <b-row>
       <b-col lg="12">
            <div class="tab-content text-muted">
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <Overview :school="school"/>
                </div>
                 <div class="tab-pane fade" id="semesters" role="tabpanel">
                    <Semester :id="school.data.id" :term="school.data.term" :dropdowns="dropdowns" />
                </div>
                 <div class="tab-pane fade" id="courses" role="tabpanel">
                    <Course :id="school.data.id" :term="school.data.term"/>
                </div>
                <div class="tab-pane fade" id="grading" role="tabpanel">
                    <Grading :id="school.data.id" :gradings="school.data.gradings"/>
                </div>
            </div>
       </b-col>
    </b-row>
</template>
<script>
import Grading from './Grading.vue';
import Semester from './Semester.vue';
import Overview from './Overview.vue';
import Course from './Course.vue';
export default {
    components: { Overview, Semester, Course, Grading },
    props: ['school','dropdowns'],
    data() {
        return {
        }
    }
}
</script>
