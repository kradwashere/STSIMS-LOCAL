<template>
    <b-row class="mb-3 mt-n2">
        <div class="col-md-3"> 
            <multiselect v-model="info.level" id="ajax" label="others" track-by="id"
                placeholder="Select Level" open-direction="bottom" :options="levels"
                :allow-empty="false"
                :show-labels="false">
            </multiselect> 
        </div>
        <div class="col-md-3">
            <multiselect v-model="info.semester" id="ajax"
                placeholder="Select Semester" open-direction="bottom" :options="semesters"
                :allow-empty="false"
                :custom-label="nameWithLang"
                :show-labels="false">
            </multiselect> 
        </div>
        <div class="col-md-6">
            <div class="hstack float-end gap-2 mt-4 mt-sm-0">
                <button @click="cstm()" v-b-tooltip.hover title="Custom list of subjects" class="btn btn-outline-primary btn-md btn-icon waves-effect waves-light" type="button">
                    <div class="btn-content"><i class="ri-menu-add-fill"></i></div>
                </button>
                <button @click="add1()" v-b-tooltip.hover title="Add Subject" class="btn btn-outline-danger btn-md btn-icon waves-effect waves-light" type="button">
                    <div class="btn-content"><i class="ri-add-circle-fill"></i></div>
                </button>
                <button @click="changeprospectus()" v-b-tooltip.hover title="Switch Prospectus" class="btn btn-outline-primary btn-md btn-icon waves-effect waves-light" type="button">
                    <div class="btn-content"><i class="ri-settings-3-fill"></i></div>
                </button>
                <button @click="create()" class="btn btn-success btn-md btn-label" type="button">
                    <div class="btn-content"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Submit </div>
                </button>
            </div>
        </div>
    </b-row>
    <hr />
    <div class="todo-content position-relative px-4 mx-n4" id="todo-content">
        <div class="col-md-12" style="overflow: auto;">
            <div class="table-responsive mt-1" v-if="lists.length > 0">
                <SimpleBar class="align-items-center d-flex justify-content-center">
                    <table class="table table-bordered mb-0">
                        <tbody class="text-center font-size-11">
                            <tr class="align-middle" v-for="list in lists" v-bind:key="list.id" style="line-height: 10px;">
                                <td @click="openModal('switch',list)" style="cursor: pointer; width: 7%;">
                                    <i v-if="list.is_lab == true" class='bx bx bxs-flask h5 mb-n2 text-warning'></i>
                                    <i v-else class='bx bxs-book-open  h5 mb-n2 text-info'></i>
                                </td>
                                <td class="fw-bold fs-12">{{ list.code }} <span v-if="list.is_lab == true" class="text-warning fw-bold">(Lab)</span></td>
                                <td>{{ list.subject }} <span v-if="list.is_lab == true" class="text-warning fw-bold">(Lab)</span></td>
                                <td style="width: 9.5%;">{{ list.unit }}</td>
                            </tr>
                        </tbody>
                    </table>
                </SimpleBar>
                <table class="table table-bordered mb-0"> 
                    <tbody class="text-center font-size-11">
                        <tr v-if="total > 0">
                            <td>
                            </td>
                            <td style="width: 9.5%;" class="fw-bold text-success">{{ total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="d-flex align-items-center justify-content-center">
                <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-info">Please select a <b>semester</b>.</div>
            </div>
        </div>
    </div>
     <!-- <input multiple type="file" @change="uploadFieldChange" class="form-control mt-3" :class="[($page.props.errors['files.'+0]) ? 'text-danger' : '']" style="width: 100%;" id="formFileSm"/> -->

    <Confirm @err="err" @status="res" :user="user" ref="confirm"/> 
    
    <Add @add="addsubject" ref="failed" /> 
    <Custom @add="addsubject" ref="custom"/>
    <Swtch @status="fetchSemesters" ref="swtch"/>
    <!-- <Prospectus ref="prospectus"/> -->
</template>
<script>
import Swtch from "../Modals/Switch.vue";
import Custom from "../Modals/Custom.vue";
import Add from "../Modals/Add.vue";
import Confirm from "../Modals/ConfirmEnrollment.vue";
// import Prospectus from "../Modals/Prospectus.vue";
import { SimpleBar } from 'simplebar-vue3';
import Multiselect from '@suadelabs/vue3-multiselect';
export default {
    components: { SimpleBar, Multiselect, Confirm, Custom, Swtch, Add },
    props: ['dropdowns','user'],
    data() {
        return {
            currentUrl: window.location.origin,
            errors: [],
            info: {
                academic_year: new Date().getFullYear()+'-'+ (new Date().getFullYear()+1),
                level: '',
                semester: '',
                subcourse: '',
            },
            semesters: [],
            lists: [],
            subjects: [],
            customs: [],
            prospec: {},
            p: null,
            custom: false,
            editable: false
        }
    },

    watch : {
        'info.level'(){
            (!this.info.semester) ? '' : this.onChange();
        },
        'info.semester'(){
            (!this.info.level) ? '' : this.onChange();
        },
        prospec(){
            this.p = this.prospec;
        }
    },

    computed : {
        levels : function() {
            return this.dropdowns.filter(x => x.classification === 'Level');
        },
        total: function() {
            var sum = 0;
            if(this.lists != undefined){
                this.lists.forEach(e => {
                    sum += Number(e.unit);
                });
            }
            return sum
        }
    },

    created(){
        this.info.level = this.user.education.level;
        this.prospec = this.user.education.info;
    },

    methods: {
        nameWithLang ({ academic_year,semester }) {
            return `${academic_year} — ${semester.name}`
        },

        create(){
            let data = new FormData();
            data.append('semester_id', (this.info.semester.id != undefined) ? this.info.semester.id : '');
            data.append('semester_id2', (this.info.semester.semester_id != undefined) ? this.info.semester.semester_id : '');
            data.append('level_id', (this.info.level.id != undefined) ? this.info.level.id : '');
            data.append('scholar_id', (this.user != undefined) ? this.user.code : '');
            data.append('lists', (this.lists.length != 0) ? JSON.stringify(this.lists) : '');
            data.append('file_type', 'enrollment');
            data.append('type', 'enrollment');

            this.$refs.confirm.set(data);
        },
        onChange(){
            this.errors = []; this.subjects = []; this.customs = [];
            if(this.p != null){
                let one, two, three, four;
                one = this.prospec;
                two = one.prospectus;
                three = two.filter(x => x.year_level === this.info.level.others);
                four = three[0].semesters.filter(x => x.semester === this.info.semester.semester.name);
                this.prospectus = Object.assign({},four[0]);
                this.lists = this.prospectus.courses;

                two.forEach((item) => {
                    item.semesters.forEach((it) => {
                        it.courses.forEach((i) => {
                            if(!i.hasOwnProperty("grade")){
                                this.subjects.push(i);
                            }
                            this.customs.push(i);
                        });
                    });
                });
            }
        },

        fetchSemesters(school,awarded_year,semester){
            axios.get(this.currentUrl + '/lists/semester/'+school+'/'+awarded_year)
            .then(response => {
                this.semesters = response.data;
                this.info.semester = semester;
                this.onChange();
            })
            .catch(err => console.log(err));
        },

        back(){
            this.$parent.set('default');
        },

        openModal(data,selected = null){
            switch(data){
                case 'switch': 
                    this.$refs.swtch.set(this.subjects,selected,this.user);
                break;
            }
        },

        addsubject(list){
            this.lists.push(list);
        },
        
        add1(){
            this.$refs.failed.set(this.customs);
        },

        cstm(){
            this.custom = true;
            this.lists = [];
            this.$refs.custom.set(this.customs);
        },

        add(){
            this.$refs.custom.show();
        },

        changeprospectus(){
            this.$refs.prospectus.show();
        }
    }
}
</script>
<style>
    .todo-content {
        height: calc(100vh - 280px);
    }
    .multiselect__single {
        font-size: 12px;
    }
</style>