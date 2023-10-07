<template>
    <b-modal v-model="showModal" hide-footer :title="province.name" class="v-modal-custom" modal-class="zoomIn" fullscreen>
        <div class="hstack gap-3 flex-wrap mt-n3">
            <div class="text-muted">
                <a class="text-primary fw-medium" href="#" target="_self">{{(province.region) ? province.region.name : ''}}</a>
            </div>
            <div class="vr"></div>
            <div class="text-muted">Region :
                <span class="text-body fw-medium">{{(province.region) ? province.region.region : ''}}</span>
            </div>
            <div class="vr"></div>
            <div class="text-muted">Total : 
                <span class="text-body fw-medium">{{province.scholars_count}} scholars</span>
            </div>
        </div>    
        <div class="row">
            <div class="col-md-12"><hr /></div>
            <div class="col-md-4">
                <div class="card overflow-hidden shadow-none"><!----><!----><div class="card-body bg-soft-danger"><!----><!----><div class="d-flex align-items-center"><div class="flex-shrink-0"><div class="avatar-sm"><div class="avatar-title bg-soft-danger text-danger rounded-circle fs-17"><i class="ri-gift-line"></i></div></div></div><div class="flex-grow-1 ms-3"><h6 class="fs-16">Invite your friends to Velzon</h6><p class="text-muted mb-0">Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally.</p></div></div><div class="mt-3 text-end"><a class="btn btn-danger" href="#!" target="_self">Invite Friends</a></div></div><!----><!----></div>
                <Chartered v-for="(list,index) in chartered" v-bind:key="index" :list="list" :programs="programs"/>
            </div>
            <div class="col-md-8">
                <Count :firsts="firsts"/>
                <Table :districts="districts" :programs="programs"/>
                <!-- <div class="card mt-2" style="height: 400px;">
                    <div class="card-header align-items-center d-flex">
                        <h6 class="card-title mb-0 flex-grow-1 fs-14">Scholarship Program Awarded Through the Years</h6>
                        <div>
                            <button @click="previous(this.year)" class="btn btn-soft-primary btn-sm me-1" type="button">
                                <div class="btn-content"> Previous </div>
                            </button>
                            <button @click="next(this.year)" class="btn btn-soft-primary btn-sm" type="button" :disabled="this.year == new Date().getFullYear() ">
                                <div class="btn-content"> Next </div>
                            </button>
                        </div>
                    </div>
                    <div class="card-body"> -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle table-centered table-nowrap mb-3">
                            <thead class="text-muted table-light fs-10">
                                <tr>
                                    <th>
                                        <span>Scholarship Program Awarded Through the Years</span>
                                        <div class="float-end mb-n2" style="margin-top: -6px;">
                                            <button @click="previous(this.year)" class="btn btn-soft-primary btn-sm me-1" type="button">
                                                <div class="btn-content"> Previous </div>
                                            </button>
                                            <button @click="next(this.year)" class="btn btn-soft-primary btn-sm" type="button" :disabled="this.year == new Date().getFullYear() ">
                                                <div class="btn-content"> Next </div>
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody style="height: 400px;">
                                <tr>
                                    <td>
                                        <Bar :options="chartOptions2" :series="series" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- </div> -->
                <!-- </div> -->
            </div>
        </div>
    </b-modal>
</template>

<script>
import Bar from '../Components/Bar.vue';
import Table from '../Components/Table.vue';
import Count from '../Components/Count.vue';
import Chartered from '../Components/Chartered.vue';
export default {
    components: { Count, Table, Bar, Chartered },
    data() {
        return {
            currentUrl: window.location.origin,
            showModal: false,
            year: new Date().getFullYear(),
            code: '',
            programs: [],
            districts: [],
            province: {},
            firsts: [],
            series: [],
            chartered: [],
            chartOptions2: {
                chart: {
                    stacked: true,
                    toolbar: {
                        show: false,
                    },
                    zoom: {
                        enabled: true,
                    },
                    id: "vuechart-example",
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "50%",
                        endingShape: "rounded",
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                xaxis: {
                    labels: {
                        rotate: -45
                    },
                    categories: [
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dec",
                    ],
                    tickPlacement: 'on'
                },
                yaxis: {
                    title: {
                        text: 'Scholars Count'
                    },
                },
                colors: ["#556ee6", "#ea6868", "#34c38f", "#f1b44c", "#a20cce", " #713d3d"],
                legend: {
                    position: "top",
                },
                fill: {
                    opacity: 1,
                },
            },
        }
    },
    methods: {
        set(list) {
            this.code = list;
            this.showModal = true;
            this.fetchStatus();
        },
        fetchStatus() {
            axios.get(this.currentUrl + '/insights'+'/'+this.code+'/edit')
            .then(response => {
                this.province = response.data.province;
                this.programs = response.data.programs;
                this.districts = response.data.districts;
                this.firsts = response.data.first;
                this.chartered = response.data.chartered;

                this.chartOptions2 = {
                    ...this.chartOptions2,
                    ...{
                        xaxis: {
                            labels: {
                                show: true,
                                rotate: -65,
                                rotateAlways: true,
                                minHeight: 100,
                                maxHeight: 180,
                                style: {
                                    colors: "red"
                                }
                            },
                            categories: response.data.categories.categories,
                            tickPlacement: 'on'
                        }
                    }
                };
                this.series = response.data.categories.lists;
            })
            .catch(err => console.log(err));
        },
        fetch() {
            axios.get(this.currentUrl + '/insights',{
                params : {
                    type : 'years',
                    province : this.province.code,
                    year: this.year
                }
            })
            .then(response => {
                this.provinces = response.data.provinces;
                this.chartOptions2 = {
                    ...this.chartOptions2,
                    ...{
                        xaxis: {
                            labels: {
                                show: true,
                                rotate: -65,
                                rotateAlways: true,
                                minHeight: 100,
                                maxHeight: 180,
                                style: {
                                    colors: "red"
                                }
                            },
                            categories: response.data.categories,
                            tickPlacement: 'on'
                        }
                    }
                };
                this.series = response.data.lists;
            })
            .catch(err => console.log(err));
        },
        previous(year){
            this.year = year - 20;
            this.fetch();
        },
        next(year){
            this.year = year + 20;
            this.fetch();
        }
    }
}
</script>
