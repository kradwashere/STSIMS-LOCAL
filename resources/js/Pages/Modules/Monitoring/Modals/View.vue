<template>
    <b-modal v-model="showModal" hide-footer class="v-modal-custom" modal-class="zoomIn" fullscreen>
        <template v-slot:header>
            <b-row class="mb-n4">
                <b-col md>
                  <b-row class="align-items-center g-3">
                    <b-col md="auto">
                        <b-img class="img-thumbnail rounded-circle avatar-md" alt="200x200" src="/images/avatars/avatar.jpg" data-holder-rendered="true"></b-img>
                    </b-col>
                    <b-col md>
                        <div>
                            <h4 class="fw-bold">{{user.profile.name}}</h4>
                            <div class="hstack gap-3 flex-wrap">
                                <div class="text-muted">Spas ID :
                                    <span class="text-body fw-medium">{{user.spas_id}}</span>
                                </div>
                                <div class="vr"></div>
                                <div class="text-muted">Program : 
                                    <span class="text-body fw-medium">{{user.program}}</span>
                                </div>
                                <div class="vr"></div>
                                <div class="text-muted">Subprogram : 
                                    <span class="text-body fw-medium">{{user.subprogram}}</span>
                                </div>
                                <div class="vr"></div>
                                <div class="text-muted">Awarded Year : 
                                    <span class="text-body fw-medium">{{user.awarded_year}}</span>
                                </div>
                            </div>
                        </div>
                    </b-col>
                  </b-row>
                </b-col>
              </b-row>
            <i @click="showModal=false" class="ri-close-circle-fill float-end" style="cursor:pointer; font-size: 40px; margin-top: -10px; margin-bottom: -20px;"></i>
        </template>
       
        <div class="row">
            <div class="col-md-12"><hr /></div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex mt-1">
                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                    <i class="ri-service-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="mb-1">Status :</p> <span :class="'badge '+user.status.color+' '+user.status.others">{{user.status.name}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex mt-4">
                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                    <i class="ri-building-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="mb-1">School :</p><h6 class="text-truncate mb-0"> {{user.education.school.name}} </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex mt-4">
                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                    <i class="mdi mdi-school-outline"></i></div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="mb-1">Course :</p> <h6 class="text-truncate mb-0"> {{user.education.course.name}} </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex mt-4">
                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                    <i class="ri-calendar-line"></i></div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="mb-1">Level :</p> <h6 class="text-truncate mb-0"> {{user.education.level.name}} <span class="text-muted fs-11">({{user.education.level.others}})</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gy-3 mt-4">
                    <div class="col-sm-12" v-for="address in user.addresses" v-bind:key="address.id">
                        <div class="form-check card-radio">
                            <label class="form-check-label" for="shippingAddress01">
                                <span v-if="address.is_permanent" class="mb-2 fw-semibold d-block text-muted text-uppercase">Permanent Address</span>
                                <span v-else class="mb-2 fw-semibold d-block text-muted text-uppercase">Home Address</span>
                                <span class="text-muted fw-normal text-wrap mb-1 d-block">{{address.address}}, {{address.municipality.name}}</span>
                                <span class="text-muted fw-normal d-block">{{address.province.name}}, {{address.region.name}}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-9">
                <div class="border-start p-4 h-100 d-flex flex-column">
                   
               
                        <ul class="nav nav-pills nav-justified nav-custom nav-custom-light mb-3 mt-n3" role="tablist">
                            <li class="nav-item">
                                <b-link class="nav-link active" data-bs-toggle="tab" href="#home" role="tab">
                                    Home
                                </b-link>
                            </li>
                            <li class="nav-item">
                                <b-link class="nav-link" data-bs-toggle="tab" href="#benefits" role="tab">
                                    Financial Benefits
                                </b-link>
                            </li>
                            <li class="nav-item">
                                <b-link class="nav-link" data-bs-toggle="tab" href="#enrollments" role="tab">
                                    Enrollments
                                </b-link>
                            </li>
                            <li class="nav-item">
                                <b-link class="nav-link" data-bs-toggle="tab" href="#nav-light-messages" role="tab">
                                    Employment History
                                </b-link>
                            </li>
                        </ul>
                        <div class="tab-content text-muted">
                            <div class="tab-pane active" id="home" role="tabpanel">
                                <Home ref="home"/>
                            </div>
                            <div class="tab-pane" id="benefits" role="tabpanel">
                                <!-- <Benefits ref="benefits"/> -->
                            </div>
                            <div class="tab-pane" id="enrollments" role="tabpanel">
                                <!-- <Enrollments ref="enrollment"/> -->
                            </div>
                        </div>
                    
                
                </div>
                
            </div>
        </div>
    </b-modal>
</template>
<script>
import Home from './Pages/Home.vue';
import Benefits from './Pages/Benefits.vue';
import Enrollments from './Pages/Enrollments.vue';
export default {
    components: {Home, Benefits, Enrollments},
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            user: {
                profile: {},
                status: {},
                education: {
                    school: {},
                    course: {},
                    level: {},
                    info: {}
                },
                addresses: []
            },
            enrollments: [],
            prospectuses: [],
            enrollment: 0,
            listE: []
        }
    },
    methods: {
        show(user){
            this.user = user;
            this.prospectuses = this.user.education.info.prospectus;
            this.fetch();
            this.showModal = true;
        },
        hide(){
            this.showModal = false;
        },
        fetch(){
            axios.get(this.currentUrl+'/monitoring', {
                params: {
                    id: this.user.id,
                    type: 'monitoring'
                }
            })
            .then(response => {
                this.enrollments = response.data.data.enrollments;
                // this.$refs.enrollment.set(this.monitoring.enrollments);
                // this.$refs.benefits.set(this.monitoring.enrollments);
                this.$refs.home.set(this.enrollments);
                // console.log(response);
                // this.monitoring = response.data.data;

                // this.prospectuses.map((list) => {
                //     list.semesters.map((semester) => {
                //         var a = [];
                //         var a = this.monitoring.enrollments.map((enrollment) => {
                //            return (semester.semester == enrollment.semester.semester.name) ? (list.year_level == enrollment.level.others) ? true : false : false;
                //         });

                //         const count = a.filter(Boolean).length;
                //         (count > 0) ? this.listE.push(true) : this.listE.push(false);
                //         semester['is_enrolled'] = ((count > 0) ? true : false);

                //         var count1 = 0; var total = 0;
                //         this.monitoring.enrollments.map((enrollment) => {
                //             if (semester.semester == enrollment.semester.semester.name) {
                //                 if (list.year_level == enrollment.level.others) {
                //                     enrollment.semester.benefits.map((benefit) => {
                //                         if (1 == benefit.benefit_id) {
                //                             count1++;
                //                         }
                //                         total = parseInt(total) + parseInt(benefit.amount);
                //                     });
                //                 }
                //             }
                //             semester['benefit_counter'] = (enrollment.semester.semester.others == 'regular') ? 5 : 2;
                //         });
                //         semester['benefit_count'] = count1;
                //         semester['benefit_total'] = total;                    
                //     });
                // });
                
            })
            .catch(err => console.log(err));
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        viewFull(){
            this.$refs.view.show(this.monitoring);
        },
        viewGrades(){
            this.$refs.grades.show(this.monitoring);
        }
    }
}
</script>
<style>
    table .unselectablez {
        background-color: #f9f9f9;
        cursor: not-allowed;
    }
    .tablez td {
        padding: 0.55rem 0.55rem;
    }
</style>