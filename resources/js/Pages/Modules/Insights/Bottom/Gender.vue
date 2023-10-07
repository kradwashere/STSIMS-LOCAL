<template>
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h5 class="card-title mb-0 flex-grow-1">Gender</h5>
            <div>
                <button class="btn btn-soft-primary btn-sm" type="button">
                    <div class="btn-content"> View all </div>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mt-n3 mb-3">
                <div class="col-md-7">
                    <apexchart ref="realtimeChart" class="apex-charts" type="pie" height="270" :series="g"
                        :options="chartOptions">
                    </apexchart>
                </div>
                <div class="col-md-5">
                    <table class="table mb-1 mt-4" v-if="gender.length > 0">
                        <tbody>
                            <tr>
                                <td>Male :</td>
                                <td>{{gender[0]['total']}}</td>
                            </tr>
                            <tr>
                                <td>Female :</td>
                                <td>{{gender[1]['total']}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['gender'],
        data() {
            return {
                currentUrl: window.location.origin,
                colors: ['bg-primary', 'bg-danger', 'bg-success', 'bg-warning', 'bg-info', 'bg-seconday'],
                series: [],
                chartOptions: {
                    chart: {
                        type: 'pie',
                        height: 100,
                    },
                    labels: ['Male', 'Female'],
                    colors: ['#0d68e3', '#e21673'],
                    legend: {
                        show: false,
                    }
                },
            }
        },
        computed : {
            g(){
                if(this.gender.length > 0){
                    return [this.gender[0]['total'],this.gender[1]['total']];
                }else{
                    return []
                }
            }
        }
    }

</script>
