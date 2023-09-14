<template>
<div class="p-4 d-flex flex-column h-100">
    <div class="mt-4 mb-3 border-bottom pb-2">
        <div class="float-end">
            <a class="link-primary" href="javascript:void(0);" target="_self">All Logout</a>
        </div>
        <h5 class="card-title">Login History</h5>
    </div>
    <div data-simplebar style="height: calc(100vh - 468px);">
        <div class="d-flex align-items-center mb-3" v-for="(list, index) of lists" :key="index">
            <div class="flex-shrink-0 avatar-sm">
                <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                    <i :class="'ri-'+list.type+'-line '+list.attempt"></i>
                </div>
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="mb-0">{{list.platform}} ({{list.browser}})</h6>
                <p class="text-muted fs-11 mb-0" v-if="list.location">{{ list.location.city }},  {{ list.location.state_name }}, {{ list.location.country }} </p>
                <p class="text-muted fs-11 mb-0" style="margin-top: -2px;"> {{ list.login_at}}</p>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            lists: []
        }
    },
    mounted(){
        this.fetch();
    },
    methods: {
        fetch(page_url){
            page_url = page_url || '/staffs';
            axios.get(page_url,{
                params : {
                    type: 'logs'
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;          
                }
            })
            .catch(err => console.log(err));
        },
    }
}
</script>