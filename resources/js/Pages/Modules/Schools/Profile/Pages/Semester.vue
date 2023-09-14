<template>
    <b-col lg>
        <div class="input-group mb-3 mt-n1">
            <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
            <input type="text" v-model="keyword" placeholder="Search Academic Year" class="form-control" style="width: 30%;">
            <b-button type="button" variant="primary" @click="newModal()">
                <i class="ri-add-circle-fill align-bottom me-1"></i> Create
            </b-button>
        </div>
    </b-col>
    <div class="table-responsive mb-3">
        <table class="table align-middle table-nowrap mb-0">
            <thead class="table-light fs-12">
                <tr>
                    <th>Academic Year</th>
                    <th class="text-center">Start at</th>
                    <th class="text-center">End at</th>
                    <th class="text-center">Semester</th>
                    <th class="text-center">Status</th>
                    <th class="text-end"></th>
                </tr>
            </thead>
            <tbody class="list form-check-all">
                <tr v-for="list in lists" v-bind:key="list.id">
                    <td class="fs-14 fw-medium">{{list.academic_year}}</td>
                    <td class="text-center">{{list.start_at}}</td>
                    <td class="text-center">{{list.end_at}}</td>
                    <td class="text-center">{{list.semester.name}}</td>
                    <td class="text-center">
                        <span v-if="list.is_active" class="badge bg-success">Active</span>
                        <span v-else class="badge bg-danger">Inactive</span>
                    </td>
                    <td class="text-end">
                        <b-button variant="soft-primary" v-b-tooltip.hover title="Edit" size="sm" class="edit-list"><i class="ri-pencil-fill align-bottom"></i> </b-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div>          
    <Semester :semesters="semesters" @status="message" ref="new"/>
</template>
<script>
import Pagination from "@/Shared/Components/Pagination.vue";
import Semester from '../Modals/Semester.vue';
export default {
    components: { Semester, Pagination },
    props: ['dropdowns','id','term'],
    data(){
        return{
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            keyword: '',
        }
    },    
    created(){
        this.fetch();
    },
    computed : {
        semesters : function() {
            return this.dropdowns.filter(x => x.classification === this.term);
        },
    },
    watch: {
        keyword(newVal){
            this.checkSearchStr(newVal)
        }
    },
    methods : {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 500),
        fetch(page_url){
            page_url = page_url || '/schools';
            axios.get(page_url,{
                params : {
                    id: this.id,
                    type: 'semesters',
                    keyword : this.keyword,
                    counts: ((window.innerHeight-600)/51)
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;                    
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                }
            })
            .catch(err => console.log(err));
        },
        newModal(){
            this.$refs.new.show(this.id);
        },
        message(){
            this.fetch();
        }
    }
}
</script>
