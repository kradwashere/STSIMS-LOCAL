<template>
    <b-col lg>
        <div class="input-group mb-3 mt-n1">
            <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
            <input type="text" v-model="keyword" placeholder="Search scholar" class="form-control" style="width: 30%;">
        </div>
    </b-col>
    <div class="table-responsive mb-3">
        <table class="table align-middle table-nowrap mb-0">
            <thead class="table-light fs-12">
                <tr>
                    <th>Name</th>
                    <th class="text-center">Scholars</th>
                    <th class="text-center">Certification</th>
                    <th class="text-center">Validity</th>
                    <th class="text-center">Status</th>
                    <th class="text-end"></th>
                </tr>
            </thead>
            <tbody class="list form-check-all">
                <tr v-for="list in lists" v-bind:key="list.id">
                    <td class="fs-12 fw-medium">{{list.course}}</td>
                    <td class="text-center">{{list.scholars}}</td>
                    <td class="text-center">{{list.certification}}</td>
                    <td class="text-center">{{list.validity}}</td>
                    <td class="text-center">
                        <span v-if="list.is_active" class="badge bg-success">Active</span>
                        <span v-else class="badge bg-danger">Inactive</span>
                    </td>
                    <td class="text-end">
                        <b-button @click="view(list)" variant="soft-primary" v-b-tooltip.hover title="View" size="sm" class="edit-list"><i class="ri-eye-fill align-bottom"></i> </b-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div>    
    <Course :type="term" ref="course"/>
</template>
<script>
import Course from '../Modals/Course.vue';
import Prospectus from '../Modals/Prospectus.vue';
import ProspectusView from '../Modals/ProspectusView.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, Prospectus, ProspectusView, Course },
    props: ['id','term'],
    computed : {
        semesters : function() {
            return this.dropdowns.filter(x => x.classification === this.term);
        }
    },
    watch: {
        keyword(newVal){
            this.checkSearchStr(newVal)
        }
    },
    data(){
        return{
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            courses: [],
            course: null,
            keyword: '',
            status: '',
            index: ''
        }
    },
    created(){
        this.fetch();
        this.fetchTopCourses();
    },
    methods : {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 500),
        addnew(){
            this.$refs.new.show(this.id);
        },
        fetch(page_url){
            page_url = page_url || '/schools';
            axios.get(page_url,{
                params : {
                    id: this.id,
                    type: 'courses',
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
        fetchTopCourses(page_url){
            page_url = page_url || '/schools';
            axios.get(page_url,{
                params : {
                    id: this.id,
                    type: 'topcourses',
                }
            })
            .then(response => {
                if(response){
                    this.courses = response.data;  
                }
            })
            .catch(err => console.log(err));
        },
        message(){
            this.fetch();
        },
        view(data){
            this.$refs.course.show(data);
            // this.course = data;
            // this.courseView = true;
        },
        openProspectus(prospectus,course,index){
            this.index = index;
            this.status = 'view';
            this.$refs.view.set(prospectus,course);
        },
        newProspectus(data){
            this.status = 'new';
            this.$refs.prospectus.show(data);
        },
        update(data){
            // this.course.prospectuses.unshift(data);
        },
        percentage(data){
            return (_.divide(data, this.total)*100).toFixed(2)+'%';
        },
    }
}
</script>
