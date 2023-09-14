<template>
    <b-row>
        <b-col lg="6">
            <b-card>
                <b-card-body style="height: calc(100vh - 355px)">
                    
                </b-card-body>
            </b-card>
        </b-col>
        <b-col lg="6">
            <div class="card" id="contactList">

                <div class="card-header">
                    <div class="row g-1">
                        <div class="col-md-4">
                            <h5 class="mt-2 ml-2">Grading System</h5>
                        </div>
                        <div class="col-md-auto ms-auto">
                            <div class="hstack float-end gap-2 mt-4 mt-sm-0">
                                <button @click="add()" v-b-tooltip.hover title="Add" class="btn btn-danger btn-md float-end me-0" type="button">
                                    <div class="btn-content"><i class="bx bxs-plus-circle"></i></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="height: calc(100vh - 392px)">
                    <div>
                        <table class="table table-sm table-bordered align-middle mt-0">
                            <thead class="text-center table-light">
                                <tr>
                                    <th>Grade</th>
                                    <th>Upper Limit</th>
                                    <th>Lower Limit</th>
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
                                     <td class="text-center" width="100px;">
                                        <b-button @click="edit(grade)" variant="soft-warning" v-b-tooltip.hover title="Edit" class="edit-list btn-sm me-1"><i class="ri-pencil-line align-bottom"></i> </b-button>
                                        <b-button @click="disable(grade)" variant="soft-danger" v-b-tooltip.hover title="Disable" class="edit-list btn-sm"><i class="ri-delete-bin-5-line align-bottom"></i> </b-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </b-col>
    </b-row>
    <Grade @status="message" ref="grade"/>
    <Disable @status="message" ref="disable"/>
</template>
<script>
import Disable from './Modals/Disable.vue';
import Grade from './Modals/Grade.vue';
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
