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
                    <th style="width: 15%;">Amount</th>
                    <th style="width: 20%;" class="text-center">Receiver Expense</th>
                    <th style="width: 20%;" class="text-center">Sender Expense</th>
                    <th style="width: 10%;" class="text-center">Status</th>
                    <th style="width: 10%;" class="text-center">Paid</th>
                    <th style="width: 15%;" class="text-center">Created Date</th>
                    <th style="width: 10%;"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(list,index) in lists" v-bind:key="list.id">
                    <td>₱{{formatMoney(list.amount)}}</td>
                    <td class="text-center">{{list.receiver.name}}</td>
                    <td class="text-center">{{list.sender.name}}</td>
                    <td class="text-center">
                        <span v-if="list.is_approved" class="badge bg-success">Approved</span>
                        <span v-else class="badge bg-danger">Waiting</span>
                    </td>
                    <td class="text-center">
                        <span v-if="list.is_paid" class="badge bg-soft-success badge-soft-success">Paid</span>
                        <span v-else class="badge bg-soft-danger badge-soft-danger">Unpaid</span>
                    </td>
                    <td class="text-center">{{list.created_at}}</td>
                    <td class="text-end">
                        <b-button  @click="view(list,index)" variant="soft-primary" v-b-tooltip.hover title="View Lists" size="sm" class="edit-list"><i class="ri-add-fill    align-bottom"></i> </b-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch()" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
    <Create :expenses="expenses" ref="create"/>
</template>
<script>
import Create from './Modals/Create.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
import Layout from "@/Shared/Layout/Index";
import profile from "@/Pages/Modules/Accounting/Index";
export default {
    layout: (h,page) => {
        return h(Layout, [
            h(profile,[page])
        ])
    },
    layout: [Layout, profile],
    components : { Create, Pagination },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            keyword: '',
            index: ''
        }
    },
     created(){
        this.fetch();
    },  
    computed: {
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
    methods: {
         checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        create(){
            this.$refs.create.set();
        },
        fetch(page_url) {
            page_url = page_url || '/accounting';
            axios.get(page_url, {
                params: {
                    keyword: this.keyword,
                    type: 'realignments',
                    counts: ((window.innerHeight-350)/56),
                    lists: true
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err));
        },
        show(){
            this.$refs.create.show();
        },
         formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
    }
}
</script>