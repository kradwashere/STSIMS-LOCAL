<template>
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h5 class="card-title mb-0 flex-grow-1">Most Courses</h5>
            <div>
                <button class="btn btn-soft-primary btn-sm" type="button">
                    <div @click="viewCourses" class="btn-content"> View all </div>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle table-centered table-nowrap mb-3">
                    <thead class="text-muted table-light fs-11">
                        <tr>
                            <th style="cursor: pointer;">  
                                <i @click="fetch('asc')" v-if="sort == 'desc'" class="ri-sort-asc"></i> 
                                <i @click="fetch('desc')" v-else class="ri-sort-desc"></i> 
                            </th>
                            <th scope="col">Course</th>
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="courses2.length > 0">
                            <tr v-for="(list,index) in courses2" v-bind:key="index">
                                <td>{{index + 1}}</td>
                                <td>{{list.name}}</td>
                                <td class="text-center">{{list.scholars_count}} </td>
                                <td class="text-center">{{percentage(list.scholars_count)}}</td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr v-for="(list,index) in courses" v-bind:key="index">
                                <td>{{index + 1}}</td>
                                <td>{{list.name}}</td>
                                <td class="text-center">{{list.scholars_count}} </td>
                                <td class="text-center">{{percentage(list.scholars_count)}}</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <Course :total="total" :ongoing="ongoing" :graduated="graduated" :sort="sort" ref="courses"/>
</template>
<script>
import Course from '../Modals/Course.vue';
export default {
    props: ['courses','total','ongoing','graduated'],
    components: { Course },
    data(){
        return {
            currentUrl: window.location.origin,
            courses2: [],
            sort: 'desc'
        }
    },
    methods : {
        fetch(sort) {
            this.sort = sort;
            axios.get(this.currentUrl + '/insights', {
                params: {
                    type: 'courses',
                    sort: sort,
                    region_code: (this.region_code) ? null : this.region_code
                }
            })
            .then(response => {
                this.courses2 = response.data;
            })
            .catch(err => console.log(err));
        },
        percentage(data){
            return (_.divide(data, this.total)*100).toFixed(2)+'%';
        },
        viewCourses(){
            this.$refs.courses.set();
        }
    }
}
</script>