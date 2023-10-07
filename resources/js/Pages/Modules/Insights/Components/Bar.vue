<template>
    <apexchart ref="realtimeChart" class="apex-charts mb-n5 mt-2" type="bar" dir="ltr" height="350" width="99%" :series="series"
        :chartOptions2="chartOptions2">
    </apexchart>
</template>
<script>
export default {
    props: ['chartOptions2','series'],
}
</script>