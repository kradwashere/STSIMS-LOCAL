<template>
<hr class="text-muted mt-n1"/>
    <table class="table tablez table-bordered table-nowrap align-middle mb-0">
        <thead class="table-light">
            <tr class="fs-11">
                <th class="text-center" width="4%">#</th>
                <th width="20%">Academic Year</th>
                <th class="text-center" width="20%">Level</th>
                <th class="text-center" width="10%">No. of Fails</th>
                <th class="text-center" width="15%">Grades Submitted</th>
                <!-- <th class="text-center" width="15%">Enrollment Status</th> -->
                <th class="text-center" width="15%">Benefits Received</th>
                <th class="text-center" width="15%">Status</th>
                <!-- <th class="text-center" width="15%">Benefit Status</th> -->
                <th></th>
            </tr>
        </thead> 
        <tbody>
            <tr class="font-size-11" v-for="(list,index) in enrollments" v-bind:key="index">
                <td class="text-center">{{index+1}}</td>
                <td class="fs-12">{{list.academic_year}} <span class="text-muted">| {{list.semester.name}}</span></td>
                <td class="text-center fs-12">{{list.level.others}}</td>
                <td class="text-center fs-12">{{check(list.grades)}}</td>
                <td class="text-center fs-12">{{check3(list.grades)}}</td>
                <!-- <td class="text-center">
                    <span v-if="!list.is_clear" class="badge bg-danger">Incomplete</span>
                    <span v-else class="badge bg-success">Cleared</span>
                </td> -->
                <td class="text-center fs-12">{{check2(list.benefits)}}</td>
                <td class="text-center">
                    <span v-if="!list.status.is_completed"><i class="text-danger ri-close-circle-fill" v-b-tooltip.hover title="Grades and Benefits not completed"></i></span>
                    <span v-else><i class="text-success ri-checkbox-circle-fill" v-b-tooltip.hover title="Grades and Benefits completed"></i></span>
                </td>
                <td>
                    <button @click="viewGrades(list)" class="btn btn-sm btn-label me-1" :class="(list.status.is_grades_completed == 1) ? 'btn-success' : 'btn-light' " type="button">
                        <div class="btn-content"><i class="ri-list-check label-icon align-middle fs-12 me-2"></i>View Grades</div>
                    </button>
                    <button @click="viewBenefits(list.benefits)" class="btn btn-sm btn-label" :class="(list.status.is_benefits_released == 1) ? 'btn-success' : 'btn-light' " type="button">
                        <div class="btn-content"><i class="ri-eye-line label-icon align-middle fs-12 me-2"></i>View Benefits</div>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <Benefits ref="benefits"/>
    <Grades ref="grades"/>
</template>
<script>
import Benefits from '../Benefits.vue';
import Grades from '../Grades';
export default {
    components : { Benefits, Grades },
    data(){
        return {
            enrollments: [],
            checks: []
        }
    },
    methods: {
        set(data){
            this.enrollments = data;
        },
        check(lists){
            const failed = lists.reduce((acc, val) => (val.is_failed == 1)  ? acc + 1 : acc, 0);
            return failed
        },
        check2(lists){
            // const count = lists.reduce((acc, val) => val.benefit_id == 1 ? acc + 1 : acc, 0);
            // const released = lists.reduce((acc, val) => (val.benefit_id == 1 && val.status_id == 13)  ? acc + 1 : acc, 0);
            // return released +' of '+count;
            const released = lists.reduce((acc, val) => (val.status_id == 13)  ? acc + 1 : acc, 0);
            return released +' of '+lists.length;
        },
        check3(lists){
            const count = lists.reduce((acc, val) => val.grade != null ? acc + 1 : acc, 0);
            return count +' of '+lists.length;
        },
        viewBenefits(list){
            this.$refs.benefits.show(list);
        },
        viewGrades(list){
            // console.log(list);
            this.$refs.grades.show(list);
        }
    }
}
</script>