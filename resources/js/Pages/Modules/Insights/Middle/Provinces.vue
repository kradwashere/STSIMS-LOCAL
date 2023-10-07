<template>
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h5 class="card-title mb-0 flex-grow-1">Provinces</h5>
            <div>
                <button @click="view()" class="btn btn-soft-primary btn-sm" type="button">
                    <div class="btn-content"> View all </div>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle table-centered table-nowrap mb-0">
                    <thead class="text-muted table-light fs-10">
                        <tr>
                            <th width="40%" scope="col">Province</th>
                            <th width="15%" style="cursor: pointer;" class="text-center" v-for="(list,index) in locations.programs" v-bind:key="index">{{list.name}}</th>
                            <th width="15%" class="text-center">Total</th>
                        </tr>
                    </thead>
                </table>
                <SimpleBar class="align-items-center d-flex justify-content-center" style="height: 275px;">
                    <table class="table table-centered table-bordered table-nowrap mb-0">
                        <tbody class="fs-11 ">
                            <tr v-for="(list,index) in locations.provinces" v-bind:key="index" :class="(list.region_code == region_code) ? 'text-info' : ''">
                                <td @click="view(list.code)" style="cursor:pointer;" width="40%" class="fw-medium">{{list.province}}</td>
                                <td width="15%" class="text-center" v-for="(count,index) in list.count" v-bind:key="index">{{count}} </td>
                                <td width="15%" class="text-center fw-bold">{{list.total}}</td>
                            </tr>
                        </tbody>
                    </table>
                </SimpleBar>

                <table class="table table-centered table-bordered table-nowrap mb-0" v-if="locations.totals">
                    <tfoot class="text-muted table-light  fs-10">
                        <tr>
                            <th style="width: 40%;">Total</th>
                            <th style="width: 15%;" class="text-center" v-for="(count,index) in locations.totals.count" v-bind:key="index">{{count}}</th>
                            <th style="width: 15%;" class="text-center">{{locations.totals.total}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <District ref="district"/>
</template>
<script>
import District from '../Modals/District.vue';
import { SimpleBar } from 'simplebar-vue3';
export default {
    components: { SimpleBar, District },
    props: ['locations','total','region_code'],
    data(){
        return {
            height: window.innerHeight - 557,
        }
    },
    methods : {
        ucwords(str) {
            let str1 = str.toLowerCase().trim();
            return (str1 + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
                return $1.toUpperCase();
            });
        },
        percentage(data){
            return (_.divide(data, this.total)*100).toFixed(2)+'%';
        },
        view(list){
            this.$refs.district.set(list);
        }
    }
}
</script>