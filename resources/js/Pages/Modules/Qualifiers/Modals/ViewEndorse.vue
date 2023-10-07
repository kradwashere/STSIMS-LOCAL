<template>
    <b-modal v-model="showModal" title="View Endorse Qualifier"  style="--vz-modal-width: 600px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered>    
        <ul class="list-unstyled mb-0 vstack gap-3" v-if="selected">
            <li>
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img :src="currentUrl+'/images/avatars/avatar.jpg'" alt="" class="avatar-sm rounded">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="fs-14 mb-1 text-primary">{{selected.name}}</h6>
                        <div class="hstack gap-3 flex-wrap">
                            <div>
                                <span :class="'badge bg-secondary '+selected.user.status.color+' '+selected.user.status.others">{{selected.user.status.name}}</span>
                            </div>
                            <div class="vr"></div>
                            <div class="fw-12">
                                {{selected.user.program.name}}
                            </div>
                            <div class="vr"></div>
                            <div class="fw-12">
                                {{selected.user.subprogram.name}}
                            </div>
                            <div class="vr"></div>
                            <div>
                                <i class="ri-map-pin-2-fill align-bottom me-1"></i> {{selected.endorser.region}}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <hr class="text-muted mt-0" />
            <table class="table mb-0">
                <tbody>
                    <tr>
                        <td class="fw-medium">School</td>
                        <td>{{selected.school}}</td>
                    </tr>
                    <tr>
                        <td class="fw-medium">Assigned Region</td>
                        <td>{{selected.region}}</td>
                    </tr>
                    <tr>
                        <td class="fw-medium">Course</td>
                        <td>{{selected.course}}</td>
                    </tr>
                </tbody>
            </table>
        </ul>

        
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Confirm</b-button>
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
            selected: {
                user:{ status:{}, program:{}, subprogram: {}},
                endorser: {}
            },
            form: {},
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
            this.selected = data;
            this.errors = [];
            this.showModal = true;
        },
        hide(){
            this.showModal = false;
        },
        create(){
             this.form = this.$inertia.form({
                id: this.selected.id,
                user: this.selected.user,
                school_id: this.selected.school_id,
                course_id: this.selected.course_id,
                type: 'endorsed'
            })

            this.form.post('/qualifiers',{
                preserveScroll: true,
                onSuccess: (response) => {
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
        },
    }
}
</script>
<style scoped>
.multiselect__single {
    font-size: 13px;
}
</style>