<template>
    <div class="p-4 d-flex flex-column h-100">
        <div class="table-responsive">
            <table class="table table-borderless table-sm table-centered align-middle table-nowrap">
                <tbody class="border-0">
                    <tr v-for="(count,index) in statistics" v-bind:key="index">
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
        <hr class="text-muted mt-n1 mb-4"/> 
        <button @click="truncate()" class="btn btn-soft-primary btn-sm w-100" type="button">
            <div class="btn-content"> Truncate </div>
        </button>
        <div class="mt-auto">
            <h6 class="fs-11 text-muted text-uppercase mb-3">SCHOOLS SEMESTER</h6>
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="ri-database-2-line fs-17"></i>
                </div>
                <div class="flex-grow-1 ms-3 overflow-hidden">
                    <div class="progress mb-2 progress-sm">
                        <div class="progress-bar bg-success" role="progressbar" style="" aria-valuenow="Infinity" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="text-muted fs-12 d-block text-truncate"><b>{{active.length}}</b> out of <b>{{statistics[2]}}</b> schools with active semester.</span>
                </div>
            </div>
        </div>
    </div>
    <Truncate ref="truncate"/>
</template>
<script>
import Truncate from '../Schools/Modals/Truncate.vue';
export default {
    components: { Truncate },
    data(){
        return {
            currentUrl: window.location.origin,
            statistics: [],
            active: [],
            options: ['Home Region Schools','Outside Region Schools','Total Schools'],
            colors: ['text-primary','text-info','text-success']
        }
    },
    created(){
        this.fetch();
    },
    methods : {
        fetch(){
            axios.get(this.currentUrl + '/schools', {
                params: { type: 'sidebar'}
            })
            .then(response => {
                this.statistics = response.data.statistics;
                this.active = response.data.active;
            })
            .catch(err => console.log(err));
        },
        truncate(){
            this.$refs.truncate.show();
        },
    }
}
</script>