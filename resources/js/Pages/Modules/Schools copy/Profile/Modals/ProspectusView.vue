<template>
    <b-modal v-if="course" v-model="showModal" hide-footer :title="course.course.name" class="v-modal-custom" modal-class="zoomIn" fullscreen>
        <template v-slot:header>
            <h5 class="modal-title">{{course.course.name}}</h5>
            <button @click="hide()" type="button" class="btn-close" aria-label="Close"></button>
        </template>
        <b-form class="customform">
            <div class="row">
                <b-tabs v-model="tabIndex">
                    <b-tab v-for="(semester,index) in semesters" v-bind:key="index">
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
                                    <div >
                                        <table class="table table-borderless align-middle">
                                            <tbody>
                                                <tr v-for="(course, index3) in s.courses" v-bind:key="'a-'+index3" class="mb-n4" style="display: block;">
                                                    <td width="12%">
                                                        <div class="form-check">
                                                            <input class="form-check-input" v-model="course.is_lab" type="checkbox" id="formCheck1">
                                                            <label class="form-check-label fs-13" for="formCheck1">&nbsp;&nbsp;Is Laboratory?</label>
                                                        </div>
                                                    </td>
                                                    <td width="14%">
                                                        <div class="form-check">
                                                            <input class="form-check-input" v-model="course.is_nonacademic" type="checkbox" id="formCheck2">
                                                            <label class="form-check-label fs-13" for="formCheck2">&nbsp;&nbsp;Is Non-Academic?</label> 
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
                                                <tr>
                                                    <td colspan="6">
                                                         <div class="d-grid gap-2">
                                                        <button @click="add(index,index2)" type="button" class="btn btn-light btn-sm mt-2 btn-block">
                                                            <i class="text-muted bx bx-plus-circle"></i>
                                                        </button>
                                                         </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                            <tr class="bg-primary bg-opacity-10">
                                                <td>
                                                    <button @click="save()" class="btn btn-success btn-md btn-label me-1" type="button">
                                                        <div class="btn-content"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Save </div>
                                                    </button>
                                                    <button @click="showModal = false" class="btn btn-danger btn-md" type="button">
                                                        <div class="btn-content"> Close </div>
                                                    </button>
                                                </td>
                                                <td>
                                                    <span class="float-end font-size-11 fw-bold me-5">Total Units: {{ totalUnits(s.courses) }}</span>
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
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            prospectus: {},
            course: { course: {}},
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
        }
    },
    computed : {
        updated: function () {
            return this.semesters;
        },
        message() {
            return (this.$page.props.flash.message) ?  true : false;
        }
    },
    methods: {
        set(prospectus,course){
            this.prospectus = prospectus;
            this.course = course;
            if(typeof this.prospectus.subjects === 'string'){
                this.semesters = JSON.parse(this.prospectus.subjects);
            }else{
                this.semesters = this.prospectus.subjects;
            }
            this.showModal = true;
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

        totalUnits(lists){
            var sum = 0;
            if(lists != undefined){
                lists.forEach(e => {
                    sum += Number(e.unit);
                });
            }
            return sum
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>
<style>
.nav-tabs {
    display: none;
}
td input {
    text-align: center;
}
</style>
