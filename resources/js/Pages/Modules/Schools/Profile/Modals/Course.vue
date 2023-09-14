<template>
    <b-modal v-model="showModal" hide-footer class="v-modal-custom" modal-class="zoomIn" fullscreen>    
        <template v-slot:header>
            <h5 class="modal-title text-primary">{{course.course}}</h5>
            <i @click="showModal=false" class="ri-close-circle-fill float-end" style="cursor:pointer; font-size: 40px; margin-top: -10px; margin-bottom: -20px;"></i>
        </template>
        <div class="hstack gap-3 flex-wrap mt-n3 mb-n2">
             <div class="text-muted"><i class="mdi mdi-school-outline align-bottom me-1"></i>
                <span class="text-body fw-medium">{{ (course.course.abbreviation) ? course.course.abbreviation : 'Not set'}}</span>
            </div>
            <div class="vr"></div>
            <div class="text-muted"><i class="ri-file-list-3-line align-bottom me-1"></i> Certification :
                <span class="text-body fw-medium">{{course.certification}}</span>
            </div>
            <div class="vr"></div>
            <div class="text-muted"><i class="ri-calendar-todo-line align-bottom me-1"></i> Validity : 
                <span class="text-body fw-medium">{{course.validity}}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><hr /></div>
            <div class="col-md-3">
                <div class="d-flex align-items-center mb-3">
                    <span class="flex-grow-1 text-muted fs-14 mb-0"> List of Prospectus</span>
                    <div class="flex-shrink-0">
                        <button @click="newProspectus(course)" class="btn btn-soft-primary btn-sm text-nowrap flex-shrink-0" type="button">
                            <div class="btn-content"><i class="ri-add-line align-bottom me-1"></i> New</div>
                        </button>
                    </div>
                </div>
                <hr />
                <div id="external-events" v-if="course.prospectuses.length > 0">
                    <div @click="openProspectus(list,index)" style="cursor: pointer;" v-for="(list, index) of course.prospectuses" :key="index" class="external-event fc-event" :class="(list.is_active) ? 'bg-soft-success text-success' : 'bg-soft-primary text-primary'">
                        <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2" :class="(list.is_active) ? 'text-success' : 'text-danger'"></i>Prospectus {{ list.school_year}} 
                        <i class="ri-lock-fill float-end" v-if="list.is_locked"></i>
                    </div>
                </div>
                <div v-else class="alert alert-light ale alert-dismissible alert-solid alert-label-icon" role="alert">
                    <i class="ri-file-warning-line  label-icon"></i>No <strong>Prospectus</strong> found. Add now
                </div>
            </div>
            <div class="col-md-9 border-start p-4 h-100 d-flex flex-column">
                <b-form class="customform">
                    <div class="row">
                        <b-tabs v-model="tabIndex">
                            <b-tab v-for="(semester,index) in semesters" v-bind:key="index">
                                <b-row class="mt-n4 mb-3">
                                    <div class="col-md-6">
                                        <div class="page-title-left mt-2">
                                            <ol class="breadcrumb m-0 fs-15">
                                                <li class="breadcrumb-item fw-bold">School Year {{prospectus.school_year}}</li>
                                                <li class="breadcrumb-item fw-semibold">
                                                    <span v-if="prospectus.is_active" class="text-success">Active</span>
                                                    <span v-else class="text-danger">Inactive</span>
                                                </li>
                                            </ol>
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="hstack float-end gap-2 mt-4 mt-sm-0">
                                             <button @click="lock(prospectus)" v-b-tooltip.hover :title="(prospectus.is_locked) ? 'Unlock' : 'Lock'" class="btn btn-sm btn-light float-end mt-1 me-0" type="button">
                                                <div v-if="prospectus.is_locked" class="btn-content"><i class="ri-lock-unlock-fill"></i></div>
                                                <div v-else class="btn-content"><i class="ri-lock-fill"></i></div>
                                            </button>
                                            <button @click="activate(prospectus)" class="btn btn-sm btn-label mt-1" :class="(prospectus.is_active) ? 'btn-danger' : 'btn-success'" type="button">
                                                <div v-if="!prospectus.is_active" class="btn-content"><i class="ri-list-check label-icon align-middle fs-12 me-2"></i>Set as Active</div>
                                                <div v-else class="btn-content"><i class="ri-list-check label-icon align-middle fs-12 me-2"></i>Set as Inactive</div>
                                            </button>
                                            <button v-if="!prospectus.is_locked" @click="save()" class="btn btn-primary btn-sm btn-label mt-1" type="button">
                                                <div class="btn-content"><i class="ri-checkbox-circle-fill label-icon align-middle fs-12 me-2"></i>Save</div>
                                            </button>
                                        </div>
                                    </div>
                                </b-row>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0"> 
                                        <thead>
                                            <tr class="text-center text-primary font-weight-bold font-size-12">
                                                <th colspan="2" class="bg-primary">
                                                    <a class="bx-tada float-start text-white" @click="nxt('back')"><i class='bx bx-chevrons-left' ></i></a>
                                                    <span class="text-white">{{semester.year_level}}</span>
                                                    <a class="bx-tada float-end text-white" @click="nxt('next')"><i class='bx bx-chevrons-right'></i></a>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <b-tabs v-model="tabIndex2">
                                        <b-tab v-for="(s,index2) in semester.semesters" v-bind:key="index2">
                                            <table class="table table-bordered mb-0"> 
                                                <thead>
                                                    <tr class="text-center text-danger font-weight-bold font-size-12">
                                                        <th colspan="2" class="bg-soft-dark">
                                                            <a class="bx-tada float-start" @click="tabIndex2--"><i class='bx bx-chevrons-left' ></i></a>
                                                            <span class="mt-2">{{s.semester}} </span>
                                                            <!-- <i @click="add(index,index2)" v-if="s.courses.length > 0" class='bx bxs-plus-circle h4 mb-n2 mt-n2 ms-2 text-muted' style="cursor: pointer;"></i> -->
                                                            <a class="bx-tada float-end" @click="tabIndex2++"><i class='bx bx-chevrons-right'></i></a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <div style="height: calc(100vh - 350px); overflow: auto;">
                                                <table class="table table-borderless align-middle">
                                                    <tbody>
                                                        <tr v-for="(course, index3) in s.courses" v-bind:key="'a-'+index3" class="mb-n4" style="display: block;">
                                                            <td width="12%">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" v-model="course.is_lab" type="checkbox" id="formCheck1">
                                                                    <label class="form-check-label fs-12" for="formCheck1">&nbsp;&nbsp;Is Laboratory?</label>
                                                                </div>
                                                            </td>
                                                            <td width="14%">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" v-model="course.is_nonacademic" type="checkbox" id="formCheck2">
                                                                    <label class="form-check-label fs-12" for="formCheck2">&nbsp;&nbsp;Is Non-Academic?</label> 
                                                                </div>                                                           
                                                            </td>
                                                            <td width="12%">
                                                                <input type="text" class="form-control" v-model="course.code" placeholder="Course code" style="text-transform: capitalize;" required>
                                                            </td>
                                                            <td width="52%">
                                                                <input type="text" class="form-control" v-model="course.subject" placeholder="Course/Subject" style="text-transform: capitalize;" required>
                                                            </td>
                                                            <td width="5%">
                                                                <input type="text" class="form-control" v-model="course.unit" placeholder="Unit" style="text-transform: capitalize;" required>
                                                            </td>
                                                            <td class="text-end" width="2%">
                                                                <b-button @click="rmv(index,index2,index3)" variant="soft-danger" v-b-tooltip.hover title="Remove" class="edit-list"><i class="ri-delete-bin-5-line align-bottom"></i> </b-button>
                                                            </td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                            <table class="table table-bordered mb-0">
                                                <tbody>
                                                    <tr class="bg-opacity-10">
                                                        <td>
                                                            <button @click="add(index,index2)" class="btn btn-secondary btn-md btn-label me-1" type="button">
                                                                <div class="btn-content"><i class="ri-add-circle-fill label-icon align-middle fs-16 me-2"></i> Add Subject </div>
                                                            </button>
                                                            <!-- <button @click="save()" class="btn btn-success btn-md btn-label me-1" type="button">
                                                                <div class="btn-content"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Save </div>
                                                            </button>
                                                            <button @click="showModal = false" class="btn btn-danger btn-md" type="button">
                                                                <div class="btn-content"> Close </div>
                                                            </button> -->
                                                        </td>
                                                        <td>
                                                            <span class="float-end font-size-11 fw-bold mt-2 me-2">Total Units: {{ totalUnits(s.courses) }}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </b-tab>
                                    </b-tabs>
                                </div>
                            </b-tab>
                        </b-tabs>

                    </div>
                </b-form>
            </div>
        </div> 
    </b-modal>
    <Prospectus :type="term" @status="update" ref="prospectus"/>
    <Lock ref="lock"/>
    <Status ref="status"/>
</template>

<script>
import Lock from './Lock.vue';
import Status from './Status.vue';
import Prospectus from './Prospectus.vue';
export default {
    components : { Prospectus, Lock, Status },
    props: ['term'],
    data() {
        return {
            currentUrl: window.location.origin,
            showModal: false,
            course: { course:{}, prospectuses: {}},
            prospectus: {},
            semesters: [],
            years: ['First Year', 'Second Year', 'Third Year', 'Fourth Year','Fifth Year'],
            total: '',
            a: '',  
            tabIndex: 0,
            tabIndex2: 0,
            showModal: false,
            editable: false,
            form: this.$inertia.form({
                id: '',
                subjects: '',
                editable: true,
                type: 'prospectus'
            }),
            status: '',
            index: '',
        }
    },
    watch: {
        data: {
            deep: true,
            handler(val = null) {
                if(val != null && val !== ''){
                    if(this.status == 'new'){
                        this.course.prospectuses.unshift(val);
                        this.openProspectus(val,0);
                    }else{
                        this.course.prospectuses[this.index] = val;
                        this.openProspectus(val,this.index);

                        if(this.status == 'status'){
                            this.course.prospectuses.forEach(item => {
                                if(item.id == val.id){
                                    item.is_active = 1;
                                }else{
                                    item.is_active = 0;
                                }
                            });
                        }
                    }
                }
            },
        },
    },
    computed : {
        updated: function () {
            return this.semesters;
        },
        message() {
            return (this.$page.props.flash.message) ?  true : false;
        },
        data() {
            return this.$page.props.flash.data;
        },
    },
    methods: {
        show(data) {
            this.course = data;
            this.showModal = true;
        },
        newProspectus(data){
            this.status = 'new';
            this.$refs.prospectus.show(data);
        },
        openProspectus(prospectus,index){
            this.index = index;
            this.prospectus = prospectus;
            if(typeof this.prospectus.subjects === 'string'){
                this.semesters = JSON.parse(this.prospectus.subjects);
            }else{
                this.semesters = this.prospectus.subjects;
            }
        },
        add(one,two){
            //      {{semesters[0].semesters[0].courses}}
            this.semesters[one].semesters[two].courses.push({code: '',subject: '',unit: '',is_lab: false,is_nonacademic: false})
        },

        rmv(one,two,three){
            // this.lists.splice(index, 1);
            this.semesters[one].semesters[two].courses.splice(three,1);
        },

        chck(index){
            this.a = index;
        },

        save(){
            this.form.id = this.prospectus.id;
            this.form.subjects = this.updated;

            this.form.put('/schools/update',{
                preserveScroll: true,
                onSuccess: (response) => {}
            });
        },

        nxt(type){
            (type == 'next') ? this.tabIndex++ : this.tabIndex--;
            this.tabIndex2 = 0;
        },

        lock(data){
            this.$refs.lock.set(data);
        },
        activate(data){
            this.status = 'status';
            this.$refs.status.set(data);
        },
        totalUnits(lists){
            var sum = 0;
            if(lists != undefined){
                lists.forEach(e => {
                    sum += Number(e.unit);
                });
            }
            return sum
        },
    }
}
</script>
