<template>
    <b-row class="g-2 mb-3 mt-n1">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="keyword" placeholder="Search Expense Class" class="form-control" style="width: 30%;">
                <select v-model="expenditure" @change="fetch()" class="form-select" id="inputGroupSelect01" style="width: 120px;">
                    <option :value="null" selected>Select Expenditure</option>
                    <option :value="list.id" v-for="list in expenditures" v-bind:key="list.id">{{list.name}}</option>
                </select>
                <span @click="refresh" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                    <i class="bx bx-refresh search-icon"></i>
                </span>
                <b-button type="button" variant="primary" @click="show()">
                    Create
                </b-button>
            </div>
        </b-col>
    </b-row>
    <div class="table-responsive">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th style="width: 35%;">Name</th>
                    <th style="width: 17%;" class="text-center">Total Allotment</th>
                    <th style="width: 17%;" class="text-center">Total Disbursement</th>
                    <th style="width: 16%;" class="text-center">Total Balance</th>
                    <th style="width: 10%;" class="text-center">Status</th>
                    <th style="width: 5%;"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(list) in lists" v-bind:key="list.id">
                    <td>
                        <h5 class="fs-13 mb-0 text-dark">{{list.name}}</h5>
                        <p class="fs-12 text-muted mb-0">{{list.expenditure.name}}</p>
                    </td>
                    <td class="text-center fs-12 fw-medium">₱{{formatMoney(list.total)}}</td>
                    <td class="text-center fs-12 fw-medium">₱{{formatMoney(list.disbursement)}}</td>
                    <td class="text-center fs-12 fw-medium">₱{{formatMoney(list.balance)}}</td>
                    <td class="text-center">
                        <span v-if="list.is_active" class="badge bg-success">Active</span>
                        <span v-else class="badge bg-danger">Inactive</span>
                    </td>
                    <td class="text-end">
                        <b-button variant="soft-primary" v-b-tooltip.hover title="View Expense" size="sm" class="edit-list me-1"><i class="ri-eye-fill align-bottom"></i> </b-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination class="ms-2 me-2" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
    <Create :expenditures="expenditures" ref="create"/>
</template>
<script>
import Create from './Modals/Create.vue';
import Layout from "@/Shared/Layout/Index";
import profile from "@/Pages/Modules/Accounting/Index";
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    layout: (h,page) => {
        return h(Layout, [
            h(profile,[page])
        ])
    },
    layout: [Layout, profile],
    props: ['dropdowns'],
    components : { Pagination, Create },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            expenditure: null,
        }
    },
    created(){
        this.fetch();
    },
    computed: {
        expenditures : function() {
            return this.dropdowns.filter(x => x.classification === 'Expenditure');
        },  
        datares() {
            return this.$page.props.flash.datares;
        }, 
    },
    watch: {
        keyword(newVal){
            this.checkSearchStr(newVal)
        },
        datares: {
            deep: true,
            handler(val = null) {
                if(val != null && val !== ''){
                    this.fetch();
                }
            },
        },
    },
    methods : {
        show(){
            this.$refs.create.show();
        },
        fetch(page_url) {
            page_url = page_url || '/accounting';
            axios.get(page_url, {
                params: {
                    keyword: this.keyword,
                    type: 'expenses',
                    counts: ((window.innerHeight-350)/56)
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err));
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },

    }
}
</script>