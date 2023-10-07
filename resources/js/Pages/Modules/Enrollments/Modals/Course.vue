<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <template v-slot:header>
            <h5 class="modal-title">Select Course</h5>
            <button @click="hide()" type="button" class="btn-close" aria-label="Close"></button>
        </template>
        <form @submit.prevent="save" class="customform">
            <div class="row mt-2">
                <div class="col-md-12 mb-n2" v-if="profile != '' && school != '' && course != ''">
                     <div class="d-flex">
                        <div class="me-3">
                            <img :src="currentUrl+'/images/avatars/'+profile.avatar" alt=""
                                class="avatar-sm rounded-circle img-thumbnail">
                        </div>
                        <div class="flex-grow-1 align-self-center">
                            <div class="text-muted">
                                <p class="text-primary font-size-15 fw-bold mb-0">
                                    {{ profile.firstname }}
                                    {{ profile.middlename[0] }}.
                                    {{ profile.lastname}} {{ profile.suffix}}
                                </p>
                                <p class="font-size-11 mt-n1 mb-0">{{school.name}}</p>
                                <p class="font-size-11 fw-bold mt-n1">{{course.name.toUpperCase() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr class="">
                    <label>Subcourse: <span v-if="errors.course_id" class="haveerror">({{ errors.course_id[0] }})</span></label>
                    <multiselect v-model="subcourse" id="ajax" label="type" track-by="id"
                        placeholder="Select Course" open-direction="bottom" 
                        :options="subcourses"
                        :allow-empty="false"
                        :show-labels="false">
                    </multiselect> 
                </div>
            </div>
        </form>
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
        data() {
            return {
                currentUrl: window.location.origin,
                errors: [],
                courses: [],
                subcourses: [],
                subcourse: '',
                course: '',
                profile: '',
                id: '',
                form: {},
                showModal: false
            }
        },

        methods: {
            set(id,profile,school,course){
                this.profile = profile;
                this.school = school;
                this.course = course;
                this.id = id;
                this.showModal = true;
                this.fetchSubcourse();
            },

            fetchSubcourse(){
                axios.get(this.currentUrl + '/lists/subcourses/'+this.school.id+'/'+this.course.id)
                .then(response => {
                    this.subcourses = response.data;
                })
                .catch(err => console.log(err));
            },
            
            create(){
                this.form = this.$inertia.form({
                    id: this.id,
                    subcourse_id: this.subcourse.id,
                    type: 'course'
                })
                this.form.post('/scholars',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.showModal = false;
                    }
                });
            },

            hide(){
                (this.form.hasOwnProperty('reset') ) ? this.form.reset().clearErrors() : this.subcourse = '';
                this.showModal = false;
            },
        }
    }
</script>
<style>.modal-header .btn-close {display: none;}</style>