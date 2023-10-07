<template>
    <b-row>
        <b-col lg="4" md="6" v-for="(item, index) of firsts" :key="index">
            <b-card no-body>
                <b-card-body>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                <i :class="`bx ${item.icon} align-middle`"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                {{ item.name }}
                            </p>
                            <h4 class="mb-0">
                                <span class="counter-value">
                                {{ item.total }}
                                </span>
                            </h4>
                        </div>
                        <div class="flex-shrink-0 align-self-end">
                            <apexchart class="apex-charts" height="40" width="100" type="area" dir="ltr" :series="item.series" :options="chartOptions"></apexchart>
                        </div>
                    </div>
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>
</template>
<script>
export default {
    props:['firsts'],
    data(){
        return {
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
            }
        }
    }
}
</script>