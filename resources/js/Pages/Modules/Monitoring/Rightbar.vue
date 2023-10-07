<template>
    <b-row class="align-items-center">
        <b-col cols="6">
            <h6 class="text-primary text-uppercase fw-semibold text-truncate fs-12 mb-3">Ongoing Scholars</h6>
            <h4 class="fs- mb-0">{{totalSum}}</h4>
            <p class="mb-0 mt-2 text-muted"><b-badge variant="soft-success" class="badge-soft-success mb-0">
                    <i class="ri-arrow-up-line align-middle"></i> 15.72 %
                </b-badge> from previous year</p>
        </b-col>
        <b-col cols="6">
            <div class="text-center">
                <img src="/images/illustrator-1.png" class="img-fluid" alt="">
            </div>
        </b-col>
    </b-row>
    <div class="mt-3 pt-2">
        <b-progress class="progress-lg rounded-pill">
            <b-progress-bar  v-for="(list,index) in modifiedItems" v-bind:key="index" :value="list.status_count" :variant="list.color" class="rounded-0" />
        </b-progress>
    </div>
    <div class="mt-3 pt-2">
        <div class="d-flex mb-2" v-for="(list,index) in modifiedItems" v-bind:key="index">
            <div class="flex-grow-1">
                <p class="text-truncate text-muted fs-14 mb-0">
                    <i class="mdi mdi-circle align-middle me-2" :class="'text-'+list.color"></i>{{list.name}}
                </p>
            </div>
            <div class="flex-shrink-0">
                <p class="mb-0">{{list.status_count}}</p>
            </div>
        </div>
    </div>
    <hr class="text-muted mb-3"/>
    <div class="hstack gap-2">
        <button class="btn btn-warning btn-sm w-100" type="button">
            <div class="btn-content"><i class="ri-printer-line align-bottom me-1"></i> Print
        </div>
        </button>
        <button class="btn btn-info btn-sm w-100" type="button">
            <div class="btn-content"><i class="ri-question-answer-line align-bottom me-1"></i> Reports</div>
        </button>
        <button @click="release(released)" class="btn btn-danger btn-sm w-100" type="button">
            <div class="btn-content"><i class="ri-hand-coin-line align-bottom me-1"></i> Released ({{released}})</div>
        </button>
    </div>
    <hr class="text-muted mb-4"/>
    <h6 class="text-primary text-uppercase fw-semibold text-truncate fs-12 mb-3">Financial Assistance Statuses</h6>
    <div v-for="(list,index) in statuses.substatuses" v-bind:key="index" class="mb-3">
        <div class="d-flex mb-2">
            <div class="flex-grow-1">
                <div>{{list.name}}</div>
            </div>
            <div class="flex-shrink-0">
                <div>{{list.status_count}} <span class="text-muted">({{percentage(list.status_count)}})</span></div>
            </div>
        </div>
        <div class="progress progress-sm animated-progess">
            <div class="progress-bar" :class="'bg-'+list.color" role="progressbar" aria-valuenow="50" aria-valuemin="0"
                aria-valuemax="100" :style="'width: '+percentage(list.status_count)"></div>
        </div>
    </div>
    <Released ref="released"/>
</template>
<script>
import Released from './Modals/Released.vue';
export default {
    components : { Released },
    props:['statuses','released'],
    computed: {
        totalSum() {
            let a = (this.statuses.statuses) ? this.statuses.statuses.reduce((sum, item) => sum + parseFloat(item.status_count), 0) : 0;
            return a;
        },
        modifiedItems() {
            let a = (this.statuses.statuses) ?  this.statuses.statuses.map(item => ({...item, color: item.color.replace('bg-', '')})) : [];
            return a;
        }
    },
    methods: {
        percentage(count){
            let a  = (count/this.totalSum) * 100;
            return a+'%';
        },
        release(data){
            this.$refs.released.show(data);
        }
    }
}
</script>