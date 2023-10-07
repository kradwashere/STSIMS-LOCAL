<template>
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h5 class="card-title mb-0 flex-grow-1">Most Schools</h5>
            <div>
                <button class="btn btn-soft-primary btn-sm" type="button">
                    <div @click="viewSchools" class="btn-content"> View all </div>
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
                            <th scope="col">School</th>
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="schools2.length > 0">
                            <tr v-for="(list,index) in schools2" v-bind:key="index">
                                <td>{{index + 1}}</td>
                                <td>{{ucwords(list.school.name)}}</td>
                                <td class="text-center">{{list.scholars_count}} </td>
                                <td class="text-center">{{percentage(list.scholars_count)}}</td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr v-for="(list,index) in schools" v-bind:key="index">
                                <td>{{index + 1}}</td>
                                <td>{{ucwords(list.school.name)}}</td>
                                <td class="text-center">{{list.scholars_count}} </td>
                                <td class="text-center">{{percentage(list.scholars_count)}}</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <School :total="total" :ongoing="ongoing" :graduated="graduated" :sort="sort" ref="schools"/>
</template>
<script>
import School from '../Modals/School.vue';
export default {
    props: ['schools','total','ongoing','graduated','region_code'],
    components : { School },
    data(){
        return {
            currentUrl: window.location.origin,
            schools2: [],
            sort: 'desc'
        }
    },
    methods : {
        fetch(sort) {
            this.sort = sort;
            axios.get(this.currentUrl + '/insights', {
                params: {
                    type: 'schools',
                    sort: sort,
                    region_code: (this.region_code) ? null : this.region_code
                }
            })
            .then(response => {
                this.schools2 = response.data;
            })
            .catch(err => console.log(err));
        },
        ucwords(str) {
            let str1 = str.toLowerCase().trim();
            return (str1 + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
                return $1.toUpperCase();
            });
        },
        percentage(data){
            return (_.divide(data, this.total)*100).toFixed(2)+'%';
        },
        viewSchools(){
            this.$refs.schools.set();
        }
    }
}
</script>