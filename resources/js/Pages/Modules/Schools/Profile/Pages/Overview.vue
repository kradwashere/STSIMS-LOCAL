<template>
<b-row>
    <b-col lg="12">
        <b-row class="g-3">
            <b-col lg="4" v-for="(item, index) of counts" :key="index">
                <b-card no-body>
                    <b-card-body>
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                    <i :class="`${item.icon} align-middle`"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                    {{ item.name }}
                                </p>
                                <h4 class="mb-0">
                                    <span class="counter-value">
                                        {{ item.counts }}
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </b-card-body>
                </b-card>
            </b-col>
            <b-col lg="12" class="mt-n2">
                <!-- <b-card>
                    <b-card-body style="height: calc(100vh - 416px)">
                        
                    </b-card-body>
                </b-card> -->
                <b-card no-body>
                    <b-card-header class="align-items-center d-flex">
                        <div class="flex-grow-1 oveflow-hidden">
                            <p class="text-muted text-truncates mb-0">Schools</p>
                        </div>
                        <div class="flex-shrink-0 ms-2">
                            <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs border-bottom-0"
                                role="tablist">
                                <li class="nav-item">
                                    <b-link class="nav-link active" data-bs-toggle="tab" href="#overview" role="tab">
                                        Overview
                                    </b-link>
                                </li>
                                <li class="nav-item">
                                    <b-link class="nav-link" data-bs-toggle="tab" href="#semesters" role="tab">
                                        Semesters
                                    </b-link>
                                </li>
                                <li class="nav-item">
                                    <b-link class="nav-link" data-bs-toggle="tab" href="#courses" role="tab">
                                        Courses
                                    </b-link>
                                </li>
                                <li class="nav-item">
                                    <b-link class="nav-link" data-bs-toggle="tab" href="#grading" role="tab">
                                        Grading
                                    </b-link>
                                </li>
                            </ul>
                        </div>
                    </b-card-header>
                    <b-card-body>
                        <div class="tab-content text-muted">
                            <div class="tab-pane active" id="overview" role="tabpanel">
                                1
                            </div>
                            <div class="tab-pane" id="semesters" role="tabpanel">
                                2
                            </div>
                            <div class="tab-pane" id="courses" role="tabpanel">
                                3
                            </div>
                            <div class="tab-pane" id="grading" role="tabpanel">
                                4
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
export default {
    props : ['school'],
    data(){
        return {
            currentUrl: window.location.origin,
            counts: []
        }
    },
    created(){
        this.fetchCount();
    },
    methods : {
        fetchCount(){
            axios.get(this.currentUrl + '/schools', {
                params: {
                    id: this.school.data.id,
                    type: 'counts'
                }
            })
            .then(response => {
                this.counts = response.data;
            })
            .catch(err => console.log(err));
        }
    }
}
</script>