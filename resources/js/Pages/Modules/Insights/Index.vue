<template>
    <Head title="Insights" />
    <PageHeader :title="title" :items="items" />
    <b-row style="height: calc(100vh - 225px); overflow: auto;">
        <b-col xxl="4">
            <Info/>
        </b-col>
        <b-col xxl="8" order-xxl="0" class="order-first">
            <Count :firsts="firsts"/>
        </b-col>
        <b-col xxl="4">
            <Provinces :locations="locations" :total="total" :region_code="region_code"/>
        </b-col>
        <b-col xxl="8">
            <Years :region_code="region_code"/>
        </b-col>
        <b-col xxl="4">
            <School :schools="schools" :total="total" :ongoing="ongoing" :graduated="graduated" :region_code="region_code"/>
        </b-col>
        <b-col xxl="4">
            <Course :courses="courses" :total="total" :ongoing="ongoing" :graduated="graduated" :region_code="region_code"/>
        </b-col>
        <b-col xxl="4">
            <Gender :gender="gender"/>
        </b-col>
    </b-row>
</template>
<script>
import Info from './Top/Info.vue';
import Count from './Top/Count.vue';
import Provinces from './Middle/Provinces.vue';
import Years from './Middle/Years.vue';
import School from './Bottom/School.vue';
import Course from './Bottom/Course.vue';
import Gender from './Bottom/Gender.vue';
import PageHeader from "@/Shared/Components/PageHeader.vue";
export default {
    props: ['region_code'],
    components : { PageHeader, Count, Info, Provinces, Years, School, Course, Gender },
    data(){
        return {
            currentUrl: window.location.origin,
            title: "Insights",
            items: [{text: "Insights",href: "/",}, {text: "Scholar",active: true, }, ],
            firsts: [],
            schools: [],
            courses: [],
            locations: [],
            gender: {},
            total: '',
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
    },
    created(){
        this.fetch();
    },
    methods: {
        fetch() {
            axios.get(this.currentUrl + '/insights', {
                params: {
                    type: 'lists',
                    sort: 'desc',
                    region_code: (this.region_code) ? null : this.region_code
                }
            })
            .then(response => {
                this.firsts = response.data.first;
                this.schools = response.data.schools;
                this.locations = response.data.locations;
                this.courses = response.data.courses;
                this.gender = response.data.gender;
                this.total = response.data.total;
                this.ongoing = response.data.ongoing;
                this.graduated = response.data.graduated;
            })
            .catch(err => console.log(err));
        }
    }
}
</script>