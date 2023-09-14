<template>
<b-row>
    <b-col lg="6">
        <b-col lg="12">
            <b-card>
                <b-card-body style="height: calc(100vh - 355px)">
                    
                    
                </b-card-body>
            </b-card>
        </b-col>
    </b-col>
    <b-col lg="6">
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
                <b-card>
                    <b-card-body style="height: calc(100vh - 450px)">
                        <div class="row">
                            <div class="col-sm-8 col-lg-4">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-success fs-24"><i
                                                    class="ri-money-dollar-circle-fill"></i></div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Class :</p>
                                            <h5 class="mb-0">{{school.data.class}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-lg-4">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-success fs-24"><i
                                                    class="ri-stack-fill"></i></div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Term :</p>
                                            <h5 class="mb-0">{{school.data.term}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-lg-4">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-success fs-24"><i
                                                    class="ri-inbox-archive-fill"></i></div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Grading :</p>
                                            <h5 class="mb-0">{{school.data.grading}}</h5>
                                        </div>
                                    </div>
                                </div>
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