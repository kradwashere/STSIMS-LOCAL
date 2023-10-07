<template>
    <b-row class="mb-3 mt-n2">
        <div class="col-md-6">
            <div class="page-title-left mt-2">
                <ol class="breadcrumb m-0 fs-15">
                    <li class="breadcrumb-item fw-bold">{{ info.month }}</li>
                    <li class="breadcrumb-item active"><span class="fw-bold text-primary">Batch {{ info.count + 1 }}</span></li>
                </ol>
            </div> 
        </div>
        <div class="col-md-6">
            <div class="hstack float-end gap-2 ">
                <button @click="back()" class="btn btn-danger btn-sm mt-2 mb-n2" type="button">
                    <div class="btn-content"> Close </div>
                </button>
            </div>
        </div>
    </b-row>
    <hr />
    <b-row>
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow" role="alert" v-if="lists.length == 0">
                <i class="ri-alert-line label-icon"></i><strong>Nothing Found</strong> - No pending benefits for release.. 
            </div>
            <div class="table-responsive" v-else>
                <table class="table table-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fs-11">
                            <th width="40%">Scholar</th>
                            <th width="40%" class="text-center">Account no.</th>
                            <th width="15%" class="text-center">Total</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                </table>
                <SimpleBar class="align-items-center d-flex justify-content-center" style="height: calc(100vh - 370px);">
                <table class="table table-nowrap align-middle mb-0">
                    <tbody>
                        <tr v-for="list in lists" v-bind:key="list.id">
                            <td width="40%">
                                <h5 class="fs-14 mb-0 text-dark">{{list.name}}</h5>
                            </td>
                            <td width="40%" class="text-center">{{list.account_no}}</td>
                            <td width="15%" class="text-center"> ₱{{ formatMoney(list.total) }}</td>
                            <td width="5%" class="text-end">
                                <b-button @click="view(list)" variant="soft-info" v-b-tooltip.hover title="View" size="sm" class="edit-list me-1"><i class="ri-eye-fill align-bottom"></i> </b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </SimpleBar>
            </div>
        </div>
    </b-row>
    <b-row class="mb-3 mt-3">
        <div class="col-md-12">
            <div class="hstack float-end gap-2 mt-4 mt-sm-0">
                <b-button v-if="lists.length != 0" @click="release()" :disabled="(lists.length == 0) ? true : false" type="button" class="w-lg float-end me-0" variant="primary">Save</b-button>
            </div>
        </div>
    </b-row>
    <Release ref="release"/>
    <View ref="view"/>
</template>
<script>
import View from '../Modals/View.vue';
import Release from '../Modals/Release.vue';
import { SimpleBar } from 'simplebar-vue3';
export default {
    components : { SimpleBar, View, Release},
    data(){
        return {
            currentUrl: window.location.origin,
            pagination: {},
            meta: {},
            links: {},
            lists: [],
            keyword: '',
            info: {},
            scholars: null
        }
    },
    methods : {
        fetch(data) {
            this.info = data;
            this.scholars = data.pending;
            if(this.scholars.length > 0){           
                axios.get('/financial-benefits/create',{
                    params : {
                        info : JSON.stringify(this.scholars),
                        type: 'benefits'
                    }
                })
                .then(response => {
                    this.lists = _.orderBy(response.data.data, 'name', 'asc');
                })
                .catch(err => console.log(err));
            }
        },

        release(){
            this.$refs.release.set(this.lists,this.info);
        },

        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },

        benefit(data){
            this.$refs.benefit.set(data);
        },

        view(data){
            this.$refs.view.set(data);
        },

        back(){
            this.$emit('status', true);
        },
    }
}
</script>