<template>
    <div class="table-responsive">
        <table class="table table-bordered align-middle table-centered table-nowrap mb-3">
            <thead class="text-muted table-light fs-10">
                <tr>
                    <th width="20%" scope="col">District</th>
                    <th style="cursor: pointer;" class="text-center" v-for="(list,index) in programs" v-bind:key="index">{{list.name}}</th>
                    <th width="10%" class="text-center">Total</th>
                </tr>
            </thead>
            <tbody class="fs-11">
                <tr v-for="(list,index) in districts" v-bind:key="index">
                    <td style="cursor: pointer;" width="20%" class="fw-medium">{{list.district}}</td>
                    <td :width="70/list.counts.length+'%'" class="text-center" v-for="(count,index) in list.counts" v-bind:key="index">{{count.count}} </td>
                    <td width="10%" class="text-center fw-bold">{{list.total}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: ['districts','programs'],
    data(){
        return {

        }
    }
}
</script>