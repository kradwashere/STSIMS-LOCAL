<template>
    <b-modal v-model="showModal" :title="(!editable) ? 'Add Grade' : 'Edit Grade'" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row customerform">
                <div class="col-md-4 mt-3">
                   <div class="form-group">
                        <label>Grade: <span v-if="form.errors" v-text="form.errors.grade" class="haveerror"></span></label>
                        <input type="text" class="form-control" v-model="grade.grade">
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                   <div class="form-group">
                        <label>Upper Limit: <span v-if="form.errors" v-text="form.errors.upper_limit" class="haveerror"></span></label>
                        <input type="text" class="form-control" v-model="grade.upper_limit">
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                   <div class="form-group">
                        <label>Lower Limit: <span v-if="form.errors" v-text="form.errors.lower_limit" class="haveerror"></span></label>
                        <input type="text" class="form-control" v-model="grade.lower_limit">
                    </div>
                </div>
                <div class="col-md-12 mt-4 mb-1" v-if="show_inc">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" v-model="grade.is_incomplete" id="gridCheck1"/>
                        <label class="form-check-label" for="gridCheck1">Is Incomplete?</label>
                    </div>
                </div>
                <div class="col-md-12" :class="(grade.is_failed) ? 'mt-4 mb-1' : 'mt-0 mb-0' " v-if="show_f">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" v-model="grade.is_failed" id="gridCheck"/>
                        <label class="form-check-label" for="gridCheck">Is a failing grade?</label>
                    </div>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button v-if="!editable" @click="create('ok')" variant="primary" :disabled="form.processing" block>Save</b-button>
            <b-button v-else @click="create('ok')" variant="primary" :disabled="form.processing" block>Update</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            showModal: false,
            grade: {
                id: '',
                grade: '',
                upper_limit: '',
                lower_limit: '',
                is_failed: false,
                is_incomplete: false,
            },
            show_f: true,
            show_inc: true,
            form: {},
            editable: false,
        }
    },
    watch : {
        'grade.is_incomplete'(){
            if(this.grade.is_incomplete){
                this.grade.is_failed = false;
                this.show_f = false;
            }else{
                this.show_f = true;
            }
        },
        'grade.is_failed'(){
            if(this.grade.is_failed){
                this.grade.is_incomplete = false;
                this.show_inc = false;
            }else{
                this.show_inc = true;
            }
        },
    },
    methods : {
        show(id) {
            this.grade = {
                id: '',
                grade: '',
                upper_limit: '',
                lower_limit: '',
                is_failed: false,
                is_incomplete: false,
            };
            this.id = id;
            this.editable = false;
            this.showModal = true;
        },

        edit(data){
            this.editable = true;
            this.grade = data;
            this.grade.is_failed = (data.is_failed) ? true : false;
            this.grade.is_incomplete = (data.is_incomplete) ? true : false;
            this.showModal = true;
        },

        create(){
            this.form = this.$inertia.form({
                id: this.grade.id,
                school_id: (this.editable) ? this.grade.school_id : this.id,
                grade: this.grade.grade,
                upper_limit: this.grade.upper_limit,
                lower_limit: this.grade.lower_limit,
                is_incomplete: this.grade.is_incomplete,
                is_failed: this.grade.is_failed,
                editable: this.editable,
                type: 'grading'
            })

            this.form.post('/schools',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },

        hide(){
            this.grade = {
                id: '',
                grade: '',
                upper_limit: '',
                lower_limit: '',
                is_failed: false,
                is_incomplete: false,
            };
            this.showModal = false;
        }
    }
}
</script>
