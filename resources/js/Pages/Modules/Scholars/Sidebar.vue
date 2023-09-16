<template>
    <div class="p-4 d-flex flex-column h-100">
        <h6 class="fs-11 text-muted text-uppercase mb-3">SCHOLARS ENROLLED</h6>
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <i class="ri-database-2-line fs-17"></i>
            </div>
            <div class="flex-grow-1 ms-3 overflow-hidden">
                <div class="progress mb-2 progress-sm">
                    <div class="progress-bar bg-success" role="progressbar" style="" aria-valuenow="Infinity" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <span class="text-muted fs-12 d-block text-truncate"><b>{{statistics.active.length}}</b> out of <b>{{statistics.statuses[0]}}</b> ongoing scholars are enrolled.</span>
            </div>
        </div>
        <hr class="text-muted mt-3 mb-3"/>
        <div class="table-responsive">
            <table class="table table-borderless table-sm table-centered align-middle table-nowrap">
                <tbody class="border-0">
                    <tr v-for="(count,index) in statistics.statuses" v-bind:key="index">
                        <td>
                            <h4 class="text-truncate fs-14 fs-medium mb-0">
                                <i class="ri-stop-fill align-middle fs-18 me-2" :class="colors[index]"></i>{{options[index]}}
                            </h4>
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
                    <tr v-for="(count,index) in statistics.types" v-bind:key="index">
                        <td>
                            <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 me-2" :class="colors[index]"></i>{{options2[index]}}</h4>
                        </td>
                        <td class="text-end">
                            <p class="fw-bold mb-0" :class="colors[index]">{{count}}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr class="text-muted mt-n1 mb-4"/>
        <ul class="list-group mb-4" style="cursor: pointer;">
            <li class="list-group-item" @click="print('graduated')"><i class="bx bxs-printer float-end fs-20 text-light align-middle me-2"></i><i class="bx fs-18 bxs-award text-warning align-middle me-2"></i>Graduates <span class="text-muted fs-11">(w/ Honor)</span> </li>
            <li class="list-group-item" @click="print('graduates')"><i class="bx bxs-printer float-end fs-20 text-light align-middle me-2"></i><i class="bx fs-18 bxs-graduation text-warning align-middle me-2"></i>List of Graduates</li>
            <li class="list-group-item" @click="print('scholars')"><i class="bx bxs-printer float-end fs-20 text-light align-middle me-2"></i><i class="ri-team-fill fs-18 text-warning align-middle me-2"></i>List of Scholars</li>
        </ul>
        <div class="mt-auto">
            <b-row class="g-1">
            <b-col lg="4">
                <button @click="download()" class="btn btn-soft-primary btn-sm w-100" type="button">
                    <div class="btn-content"> Download </div>
                </button>
            </b-col>
            <b-col lg="4">
                <button @click="truncate()" class="btn btn-soft-primary btn-sm w-100" type="button">
                    <div class="btn-content"> Truncate </div>
                </button>
            </b-col>
            <b-col lg="4">
                <button @click="sync(statistics.sync)" class="btn btn-primary btn-sm w-100" type="button">
                    <div class="btn-content"> Sync ({{statistics.sync}})</div>
                </button>
            </b-col>
        </b-row>
        </div>
    </div>
    <Download ref="download" @info="refresh()"/>
    <Truncate ref="truncate" @info="refresh()"/>
    <Sync ref="sync"/>
</template>
<script>
import Sync from './Modals/Sync.vue';
import Download from './Modals/Download.vue';
import Truncate from './Modals/Truncate.vue';
export default {
    components : { Download, Truncate, Sync},
    data(){
        return {
            currentUrl: window.location.origin,
            statistics: { statuses: [], types: [], active:[], sync: '' },
            options: ['Ongoing Scholars','Graduated Scholars','Total Scholars'],
            options2: ['Undegraduate Scholarhip','Junior Level Science Scholarship'],
            colors: ['text-primary','text-info','text-success'],
            type: ''
        }
    },
    created(){
        this.fetch();
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
        download(){
            this.$refs.download.show();
        },
        truncate(){
            this.$refs.truncate.show();
        },
        sync(count){
            this.$refs.sync.show(count);
        },
        updateSync(){
            this.statistics.sync = this.statistics.sync + 1;
        },
        refresh(){
            this.fetch();
            this.$emit('info',true);
        },
        updateUnsync(data){
            this.statistics.sync = this.statistics.sync - parseInt(data);
        },
        print(){
            
        },
    }
}
</script>