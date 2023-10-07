<template>
    <div class="p-4 d-flex flex-column h-100">
        <div class="d-flex align-items-center mb-4">
            <div class="avatar-sm flex-shrink-0">
                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                    <i :class="`bx ${item.icon} align-middle`"></i>
                </span>
            </div>
            <div class="flex-grow-1 ms-3">
                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                    {{item.year}} {{ item.name }}
                </p>
                <h4 class="mb-0">
                    <span class="counter-value">
                    {{ item.current }}
                    </span>
                </h4>
            </div>
            <div class="flex-shrink-0 align-self-end">
                <apexchart class="apex-charts" height="40" width="100" type="area" dir="ltr" :series="item.series" :options="chartOptions"></apexchart>
            </div>
        </div>
        <hr class="text-muted mt-n1 mb-3"/>
        <div class="table-responsive">
            <table class="table table-borderless table-sm table-centered align-middle table-nowrap">
                <tbody class="border-0">
                    <tr v-for="(count,index) in item.statistics" v-bind:key="index">
                        <td>
                            <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 me-2" :class="colors[index]"></i>{{options[index]}}</h4>
                        </td>
                        <td class="text-end">
                            <p class="fw-bold mb-0" :class="colors[index]">{{count}}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr class="text-muted mt-n1 mb-3"/>
            <div class="table-responsive">
            <table class="table table-borderless table-sm table-centered align-middle table-nowrap">
                <tbody class="border-0">
                    <tr v-for="(count,index) in item.statistics2" v-bind:key="index">
                        <td>
                            <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 me-2" :class="colors2[index]"></i>{{options2[index]}}</h4>
                        </td>
                        <td class="text-end">
                            <p class="fw-bold mb-0" :class="colors2[index]">{{count}}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr class="text-muted mt-n1 mb-3"/>
        <h6 v-if="item.endorsements" class="fw-semibold text-primary">ENDORSEMENTS (<span class="text-danger">{{item.endorsements.length}}</span>):</h6>
        <div data-simplebar :style="'height: '+hayt+'px'">
            <div class="p-3">

            <template v-for="(item, index) of item.endorsements" :key="index">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-grow-1 ms-n2">
                        <h6 class="fs-14 mb-0">{{ item.name }}</h6>
                        <p class="text-muted fs-12 mb-0">
                        <i class="ri-map-pin-fill text-primary fs-12 align-middle"></i>
                        {{ item.endorser.name}}, {{item.endorser.region }}
                        </p>
                    </div>
                    <div class="text-end">
                        <button @click="showViewendorse(item)" class="btn btn-sm btn-soft-secondary mt-n2 me-n2"><i class="ri-eye-fill"></i></button>
                    </div>
                </div>
            </template>
            </div>
        </div>
    </div>
    <ViewEndorse ref="viewendorse"/>
</template>
<script>
import ViewEndorse from './Modals/ViewEndorse.vue';
export default {
    components : { ViewEndorse },
    data(){
        return {
            currentUrl: window.location.origin,
            statistics: { statuses: [], types: [], active:[], sync: '' },
           options: ['Waiting','Deferment','Not Avail','Enrolled'],
            options2: ['Completed','Lacking','Potential'],
            colors2: ['text-success','text-warning','text-danger'],
            colors: ['text-warning','text-danger','text-dark','text-success'],
            type: '',
            item: { series: []},
            chartOptions: {
                chart: {
                    type: 'area',
                    height: 40,
                    sparkline: {
                        enabled: true
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                dataLabels: {
                    enabled: false
                },
                colors: ['#f1b44c'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.45,
                        opacityTo: 0.05,
                        stops: [25, 100, 100, 100]
                    },
                },
                tooltip: {
                    fixed: {
                        enabled: false
                    },
                    x: {
                        show: true
                    },
                    marker: {
                        show: false
                    }
                }
            },
        }
    },
    created(){
        this.fetch();
        this.fetchInsights();
    },
    methods: {
        fetch(){
            axios.get(this.currentUrl + '/scholars', {
                params: { type: 'statistics'}
            })
            .then(response => {
                this.statistics = response.data;
            })
            .catch(err => console.log(err));
        },
        fetchInsights() {
            axios.get(this.currentUrl + '/qualifiers',{
                params: { type: 'insights' }
            })
            .then(response => {
                this.item = response.data;
            })
            .catch(err => console.log(err));
        },
        showViewendorse(data){
            this.$refs.viewendorse.show(data);
        },
    }
}
</script>