<template>
    <b-row class="g-2 mb-3 mt-n1" v-if="!show">
        <b-col lg="12">
            <div class="input-group mb-1">
                <label class="input-group-text bg-light"> <i class='bx bx-search-alt'></i></label>
                <input type="text" class="form-control" style="width: 25%;" placeholder="Search..." v-model="keyword" @keyup="fetch()"/>
                <select  v-model="month" @change="fetch()" placeholder="Choose Level" class="form-select" :class="(term == null) ? 'text-muted' : ''" style="width: 120px;">
                    <option :value="null" selected>Select Month</option>
                    <option :value="m" v-for="(m,index) in months" v-bind:key="index">{{ m }}</option>
                </select>
                <input type="text" class="form-control" style="width: 120px;" placeholder="Enter Year" v-model="year"  @keyup="fetch()"/>
            </div>
        </b-col>
        <b-col lg="12">
            <div class="table-responsive">
                <table class="table table-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fs-11">
                            <th>Release Month</th>
                            <th class="text-center">Receiver</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Added By</th>
                            <th class="text-center">Released Date</th>
                            <th class="text-center">Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(list,index) in lists" v-bind:key="list.id">
                            <td>
                                <h5 class="fs-13 mb-0 text-dark">{{list.month}}</h5>
                                <p class="fs-12 text-muted mb-0">Batch {{list.batch }}</p>
                            </td>
                            <td class="text-center">{{list.lists.length}} Scholar<span v-if="list.lists.length > 1">s</span></td>
                            <td class="text-center"> ₱{{ formatMoney(list.total) }}</td>
                            <td class="text-center">{{list.added_by.firstname}} {{list.added_by.lastname}}</td>
                            <td class="text-center">{{list.created_at}}</td>
                            <td class="text-center">
                                <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                            </td>
                            <td class="text-end">
                                <b-button @click="print(list.id)" variant="soft-primary" v-b-tooltip.hover title="Print" size="sm" class="edit-list me-1"><i class="ri-printer-fill align-bottom"></i> </b-button>
                                <b-button @click="viewLbp(list)" variant="soft-warning" v-b-tooltip.hover title="View LBP" size="sm" class="edit-list me-1"><i class="ri-bank-line align-bottom"></i> </b-button>
                                <b-button @click="viewList(list)" variant="soft-info" v-b-tooltip.hover title="View" size="sm" class="edit-list me-1"><i class="ri-eye-fill align-bottom"></i> </b-button>
                                <b-button v-if="list.status.name != 'Released'" @click="viewConfirmation(list,index)" variant="soft-success" v-b-tooltip.hover title="Mark as Completed" size="sm" class="edit-list me-1"><i class="ri-checkbox-circle-fill align-bottom"></i> </b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
            </div>
        </b-col>
    </b-row>
    <LBP ref="lbp"/>
    <Confirm ref="confirm"/>
    <List ref="list"/>
</template>
<script>
import LBP from '../Modals/LBP.vue';
import List from '../Modals/List.vue';
import Confirm from '../Modals/Confirm.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components : { Pagination, Confirm, List, LBP },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            month: null,
            year: null,
            keyword: null
        }
    },
    created(){
        this.fetch();
    },
    computed: {
        data() {
            return this.$page.props.flash.data;
        },
    },
    watch: {
        data: {
            deep: true,
            handler(val = null) {
                if(val != null && val !== ''){
                    this.fetch();
                }
            },
        },
    },
    methods: {
        fetch(page_url){
            page_url = page_url || '/financial-benefits';
            axios.get(page_url,{
                params : {
                    keyword : this.keyword,
                    count: Math.floor((window.innerHeight - 320) / 60),
                    month: this.month,
                    year: this.year,
                    type: 'lists'
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                }
            })
            .catch(err => console.log(err));
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        viewLbp(data){
            this.$refs.lbp.set(data);
        },
        viewConfirmation(data,index){
            this.index =  index;
            this.$refs.confirm.set(data);
        },
        viewList(data){
            this.$refs.list.set(data);
        },
        print(id){
            window.open(this.currentUrl + '/financial-benefits/'+id+'/edit');
        },
    }
}
</script>