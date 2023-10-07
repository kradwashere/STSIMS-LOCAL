<template>
<Head :title="school.data.name" />
    <Headr :school="school"/>
    <b-row>
       <Sidebar :id="school.data.id"/>
        <b-col lg="8">
            <b-row>
                <Count :school="school"/>
                <b-col lg="12">
                    <b-card no-body>
                        <b-card-header class="align-items-center d-flex">
                            <div class="flex-shrink-0 ms-2">
                                <ul class="nav justify-content-start nav-tabs-custom rounded card-header-tabs border-bottom-0"
                                    role="tablist">
                                    <li class="nav-item">
                                        <b-link class="nav-link active" data-bs-toggle="tab" href="#overview" role="tab">
                                            Overview
                                        </b-link>
                                    </li>
                                    <li class="nav-item">
                                        <b-link class="nav-link" data-bs-toggle="tab" href="#courses" role="tab">
                                            Courses
                                        </b-link>
                                    </li>
                                    <li class="nav-item">
                                        <b-link class="nav-link" data-bs-toggle="tab" href="#semesters" role="tab">
                                            Semesters
                                        </b-link>
                                    </li>
                                    <li class="nav-item">
                                        <b-link class="nav-link" data-bs-toggle="tab" href="#grading" role="tab">
                                            Grading
                                        </b-link>
                                    </li>
                                </ul>
                            </div>
                             <div class="flex-grow-1 oveflow-hidden">
                                <p class="text-muted text-end xtext-truncates mb-0">Schools</p>
                            </div>
                        </b-card-header>
                        <b-card-body style="height: calc(100vh - 443px)">
                            <div class="tab-content text-muted">
                                <div class="tab-pane active" id="overview" role="tabpanel">
                                    1
                                </div>
                                <div class="tab-pane" id="semesters" role="tabpanel">
                                    <Semester :id="school.data.id" :term="school.data.term" :dropdowns="dropdowns" />
                                </div>
                                <div class="tab-pane" id="courses" role="tabpanel">
                                    <Course :id="school.data.id" :term="school.data.term"/>
                                </div>
                                <div class="tab-pane" id="grading" role="tabpanel">
                                    <Grading :id="school.data.id" :gradings="school.data.gradings"/>
                                </div>
                            </div>
                        </b-card-body>
                    </b-card>
                </b-col>
            </b-row>
       </b-col>
    </b-row>
</template>
<script>
import Headr from './Headr.vue';
import Count from './Count.vue';
import Sidebar from './Sidebar.vue';
import Course from './Pages/Course.vue';
import Grading from './Pages/Grading.vue';
import Semester from './Pages/Semester.vue';
export default {
    components: { Sidebar, Headr, Count, Course, Semester, Grading },
    props: ['school','dropdowns']
}
</script>
