<template>
    <div class="table-responsive">
        <table class="table table-bordered align-middle table-centered table-nowrap mb-3">
            <thead class="text-muted table-light fs-10">
                <tr>
                    <th width="20%" scope="col">Chartered City</th>
                    <th  class="text-center" width="15%" scope="col">District</th>
                    <th style="cursor: pointer;" class="text-center" v-for="(list,index) in programs" v-bind:key="index">{{list.name}}</th>
                    <th width="15%" class="text-center">Total</th>
                </tr>
            </thead>
            <tbody class="fs-11">
                <tr>
                    <td style="cursor: pointer;" class="fw-bold text-primary" width="20%" rowspan="4">{{list.municipality}}</td>
                </tr>
                <tr v-for="(list,index) in list.data" v-bind:key="index">
                    <td v-if="list.district == 'not set'" width="15%" class="fw-medium text-center"><code>not set</code></td>
                    <td v-else style="cursor: pointer;" width="15%" class="fw-medium text-center">{{list.district}}</td>
                    <td :width="50/list.counts.length+'%'" class="text-center" v-for="(count,index) in list.counts" v-bind:key="index">{{count.count}} </td>
                    <td width="15%" class="text-center fw-bold">{{list.total}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: ['list','programs'],
    data(){
        return {

        }
    }
}
</script>