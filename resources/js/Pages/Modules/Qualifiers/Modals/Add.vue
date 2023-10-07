<template>
    <b-modal v-model="showModal" title="Add as Scholar"  style="--vz-modal-width: 600px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered>    
        <ul class="list-unstyled mb-0 vstack gap-3" v-if="user">
            <li>
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img :src="currentUrl+'/images/avatars/'+user.profile.avatar" alt="" class="avatar-sm rounded">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="fs-14 mb-1 text-primary">{{user.profile.name}}</h6>
                        <span :class="'badge bg-secondary '+user.status.color">{{user.status.name}}</span>
                    </div>
                </div>
            </li>
            <hr class="text-muted mt-0" />
        </ul>

        <b-form class="customform mb-2">
            <div class="row customerform">
               <div class="col-md-12">
                    <label>School: <span v-if="errors.length > 0" class="haveerror">({{ errors[0].school_id }})</span></label>
                    <multiselect v-model="school" id="ajax" label="name" track-by="id"
                        placeholder="Search School" open-direction="bottom" :options="schools"
                        :searchable="true" 
                        :allow-empty="false"
                        :show-labels="false"
                        @search-change="asyncSchool">
                    </multiselect> 
                </div>
                <div class="col-md-12 mt-2" v-if="school">
                    <label>Course: <span v-if="errors.length > 0" class="haveerror">({{ errors[0].course_id }})</span></label>
                    <multiselect 
                        v-model="course" 
                        id="ajax" 
                        label="course" track-by="id"
                        placeholder="Search Course" 
                        open-direction="bottom" 
                        :options="courses"
                        :searchable="true" 
                        :allow-empty="false"
                        :show-labels="false">
                    </multiselect> 
                </div>
                 <div class="col-md-12 mt-2">
                    <hr />
                 </div>
                <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <label>Account No.: <span v-if="form.errors" v-text="form.errors.account_no" class="haveerror"></span></label>
                        <input type="text" class="form-control" v-model="account_no">
                    </div>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Save</b-button>
        </template>
    </b-modal>
</template>
<script>
import Multiselect from '@suadelabs/vue3-multiselect';
export default {
    components: { Multiselect },
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            user: {
                status: {},
                address: {
                    info: {}
                },
                profile: {},
            },
            form : {},
            profile_id : '',
            lrn: '',
            program_id: '',
            schools: [],
            courses: [],
            school: '',
            course: '',
            account_no: '',
            showModal: false,
        }
    },
    watch : {
        school(newVal){
            if(newVal != null){
                this.course = '';
                this.courses = newVal.courses;
            }
        },
    },
    methods : {
        show(data){
            this.user = data;
            this.errors = [];
            this.showModal = true;
        },
        hide(){
            this.showModal = false;
        },
        create(){
             this.form = this.$inertia.form({
                user: this.user,
                school_id: this.school.id,
                course_id: this.course.course_id,
                account_no: this.account_no,
                type: 'enroll'
            })

            this.form.post('/qualifiers',{
                preserveScroll: true,
                onSuccess: (response) => {
                    (response.data) ? $emit('info',true) : '';
                    this.clear();
                },
            });
        },
        clear(){
            this.school = '';
            this.course = '';
            this.showModal = false;
        },
        asyncSchool(value) {
            if(value.length > 3){
                axios.post(this.currentUrl + '/lists/search/schools', {
                    word: value,
                })
                .then(response => {
                    this.schools = response.data.data;
                })
                .catch(err => console.log(err));
            }
        }
    }
}
</script>
<style scoped>
.multiselect__single {
    font-size: 13px;
}
</style>