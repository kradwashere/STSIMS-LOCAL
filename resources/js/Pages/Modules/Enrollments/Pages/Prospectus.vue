<template>
    <b-row class="mb-4">
        <b-col order="3" order-sm="2" class="mt-3 mt-sm-0" sm>
            <h5 class="fw-semibold mb-0">Student Prospectus</h5>
        </b-col>
    </b-row>
    <div class="todo-content position-relative px-4 mx-n4" id="todo-content">
        <div class="col-md-12" :style="{ height: (height) + 'px' }" style="overflow: auto;">
            <div class="table-responsive" :class="(index == 0) ? 'mt-0' : 'mt-3'" v-for="(year,index) in pros.prospectus" v-bind:key="index">
                <table class="table table-bordered mb-0"> 
                    <thead>
                        <tr class="text-light text-center font-weight-bold font-size-11 bg-dark">
                            <th>
                                {{ year.year_level }}
                            </th>
                        </tr>
                    </thead>
                </table>
                <div class="row g-0">
                    <div :class="(semester.semester == 'Summer Class') ? 'col-md-12' : 'col-md-6'" v-for="(semester,index) in year.semesters" v-bind:key="index">
                        <table class="table table-bordered mb-0" v-if="semester.courses.length > 0"> 
                            <thead>
                                <tr class="text-dark text-center font-weight-bold font-size-11" style="background-color: #ededed;">
                                    <th colspan="3">
                                        {{ semester.semester }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="font-size-11" v-for="(course,index) in semester.courses" v-bind:key="index">
                                    <td width="15%" class="text-center fw-bold fs-11">{{course.code}}</td>
                                    <td width="70%" class="text-center text-muted fs-11">{{course.subject}}</td>
                                    <td class="text-center fw-bold fs-11" width="15%" v-if="!course.hasOwnProperty('grades')">
                                        {{ course.grade}}
                                    </td>
                                    <td class="text-center fw-bold fs-11" width="15%" v-else>
                                        <span :class="(grade > 3 || grade == 'F') ? 'text-danger' : 'text-dark'" v-for="(grade,index) in course.grades" v-bind:key="index">
                                            <span class="text-muted" v-if="course.grades.length > 1 && index != 0"> / </span> {{grade}} 
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    inject: ['height'],
    data(){
        return {
            currentUrl: window.location.origin,
            pros: {},
            updated_at: ''
        }
    },

    methods : {
        set(prospectus){
            this.pros = prospectus;
        },
        back(){
            this.$parent.set('default');
        }
    }
}
</script>
<style>
    .todo-content {
        height: calc(100vh - 280px);
    }
</style>