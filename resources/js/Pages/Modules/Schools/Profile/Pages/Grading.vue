<template>
    <div class="input-group mb-3 mt-n1">
        <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
        <input type="text" v-model="keyword" placeholder="Search Grade" class="form-control" style="width: 30%;">
        <b-button type="button" variant="primary" @click="add()">
            <i class="ri-add-circle-fill align-bottom me-1"></i> 
        </b-button>
    </div>
    <div>
        <table class="table table-sm table-bordered align-middle mt-0">
            <thead class="text-center table-light">
                <tr>
                    <th>Grade</th>
                    <th>Upper Limit</th>
                    <th>Lower Limit</th>
                    <th>Failed</th>
                    <th>Incomplete</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(grade, index) in gradings" v-bind:key="'a-'+index" class="mb-n4 text-center"  :class="[(!grade.is_active) ? 'table-warning' : '']">
                    <td>
                        {{grade.grade}} <span v-if="grade.is_failed">/ Failed</span><span v-if="grade.is_incomplete">/ Incomplete</span>
                    </td>
                    <td>
                        {{grade.upper_limit}}
                    </td>
                    <td>
                        {{grade.lower_limit}}
                    </td> 
                    <td>
                        <span v-if="grade.is_failed" class="badge bg-success">True</span>
                        <span v-else class="badge bg-danger">False</span>
                    </td> 
                    <td>
                         <span v-if="grade.is_incomplete" class="badge bg-success">True</span>
                        <span v-else class="badge bg-danger">False</span>
                    </td> 
                    <td class="text-center" width="100px;">
                        <b-button @click="edit(grade)" variant="soft-warning" v-b-tooltip.hover title="Edit" class="edit-list btn-sm me-1"><i class="ri-pencil-line align-bottom"></i> </b-button>
                        <b-button @click="disable(grade)" variant="soft-danger" v-b-tooltip.hover title="Disable" class="edit-list btn-sm"><i class="ri-delete-bin-5-line align-bottom"></i> </b-button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <Grade @status="message" ref="grade"/>
    <Disable @status="message" ref="disable"/>
</template>
<script>
import Disable from '../Modals/Disable.vue';
import Grade from '../Modals/Grade.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    props: ['id','gradings'],
    components: { Pagination, Grade, Disable },
    data(){
        return{
            currentUrl: window.location.origin
        }
    },
    watch: {
        datares: {
            deep: true,
            handler(val = null) {
                if(val != null && val !== ''){
                   this.gradings.push(val); 
                }
            },
        },
    },
    computed: {
        datares() {
            return this.$page.props.flash.datares;
        },
    },
    methods: {
        add(){
            this.$refs.grade.show(this.id);
        },
        disable(data){
            this.$refs.disable.show(data,'disable');
        },
        edit(data){
            this.$refs.grade.edit(data);
        }
    }
}
</script>
