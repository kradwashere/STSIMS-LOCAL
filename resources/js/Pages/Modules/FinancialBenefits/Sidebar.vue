<template>
    <b-row>
        <b-col xxl="12">

            <b-row class="g-1 mb-2">
                <b-card no-body class="card-height-100">
                    <b-card-body>
                        <div class="p-3 mt-n3 mx-n3 bg-soft-info rounded-top">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fs-14"><a class="text-dark">{{ latest.month }}</a></h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="d-flex gap-1 align-items-center my-n2">
                                        <button class="btn btn-transparent btn-md btn avatar-xs p-0 favourite-btn active" type="button">
                                            <div class="btn-content">
                                                <span class="avatar-title bg-transparent fs-15">
                                                    <i class="ri-star-fill"></i>
                                                </span>
                                            </div>
                                        </button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column h-100 mt-3">
                            <div class="mt-auto">
                                <div class="d-flex mb-2">
                                    <div class="flex-grow-1">
                                        <div>Received Stipend</div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div>
                                        <i class="ri-account-circle-fill align-bottom me-1 text-muted"></i>
                                        {{latest.received}} / {{latest.ongoing}}
                                        </div>
                                    </div>
                                </div>
                                <div class="progress progress-sm animated-progess">
                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="34" aria-valuemin="0"
                                    aria-valuemax="100" :style="`width: ${(latest.scholars.length / latest.ongoing) * 100}%;`"></div>
                                </div>
                            </div>
                        </div>
                    </b-card-body>
                    <b-card-footer class="bg-transparent border-top-dashed py-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="avatar-group">
                                    <b-link v-for="(list, index) of latest.scholars" :key="index" class="avatar-group-item" v-b-tooltip.hover :title="list.name">
                                        <div class="avatar-xxs" v-if="list.avatar != 'avatar.jpg'">
                                            <img :src="currentUrl+'/images/avatars/'+list.avatar" alt="" class="rounded-circle img-fluid" />
                                        </div>
                                        <div class="avatar-xxs" v-else>
                                            <div class="avatar-title fs-16 rounded-circle bg-primary border-dashed border text-white">
                                                {{ list.name[0] }}
                                            </div>
                                        </div>
                                    </b-link>
                                    <a class="avatar-group-item" target="_self" style="cursor: default;">
                                        <div class="avatar-xxs">
                                            <div class="avatar-title rounded-circle bg-light text-primary">+</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="text-muted">
                                    {{latest.scholars.length}} Scholar<span v-if="latest.scholars.length > 1">s</span>
                                </div>
                            </div>
                        </div>
                    </b-card-footer>
                </b-card>
                <hr class="mt-0"/>
                 <b-col lg="6" class="mt-0">
                    <button @click="newRelease" class="btn btn-primary w-100" type="button">
                        <div class="btn-content">Generate </div>
                    </button> 
                </b-col>
                <b-col lg="6" class="mt-0">
                    <button @click="reimburse()" class="btn btn-light w-100" type="button">
                        <div class="btn-content"> Reimbursement </div>
                    </button>
                </b-col>
            </b-row>
            
            <hr class="mt-3"/>
            
        </b-col>
    </b-row>
    <Reimbursement :privileges="privileges" ref="reimbursement" @info="update"/>
</template>
<script>
import Reimbursement from './Modals/Reimbursement.vue';
export default {
    components: { Reimbursement },
    props: ['privileges','dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            latest: { pending: [], scholars: [] },
        }
    },
    methods: {
        set(data){
            this.latest = data;
        },
        newRelease() {
           this.$emit('info',true);
        },
        reimburse(){
            this.$refs.reimbursement.set();
        },
        update(){
            this.$emit('update',true);
        }
    }
}
</script>