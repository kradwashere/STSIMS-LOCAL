<template>
<!-- style="--vz-modal-width: 590px;" -->
    <b-modal v-model="showModal" :title="'View Allotment ('+info.code+')'" header-class="p-3 bg-light" size="lg" class="v-modal-custom" modal-class="zoomIn" centered hide-footer>    
        <b-form class="customform mb-2">
            <div class="row mb-4" v-if="info">
                <div class="col-md-12">
                    <!-- <div class="card-header border-0 align-items-center d-flex mb-3">
                        <h4 class="card-title mb-n2 flex-grow-1">{{info.code}}</h4>
                        <div class="hstack gap-1">
                            <button class="btn btn-soft-secondary btn-sm" type="button">
                                <div class="btn-content">{{info.created_at}}</div>
                            </button>
                        </div>
                    </div> -->
                    <div class="card-header p-0 border-0 bg-soft-light">
                        <div class="row g-0 text-center">
                            <div class="col-sm-3">
                                <div class="p-3 border border-dashed border-start-0">
                                <h6 class="mb-1 fw-semibold text-primary"><span>{{info.check_no}}</span></h6>
                                <p class="text-muted mb-0">Check no.</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="p-3 border border-dashed border-start-0">
                                <h6 class="mb-1 fw-semibold text-primary"><span>{{info.checked_at}}</span></h6>
                                <p class="text-muted mb-0">Checked At</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="p-3 border border-dashed border-start-0">
                                <h6 class="mb-1 fw-semibold text-primary"><span>{{info.credited_at}}</span></h6>
                                <p class="text-muted mb-0">Credited At</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="p-3 border border-dashed border-start-0 border-end-0">
                                <h6 class="mb-1 fw-semibold text-primary"><span>₱{{formatMoney(info.total)}}</span></h6>
                                <p class="text-muted mb-0">Total</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr class="text-muted" />
                    <b-row class="g-2 mt-n3 mb-n2">
                        <b-col lg>
                            <h5 class="fs-14 mt-1 mb-0">List of Sub Allotments</h5>
                        </b-col>
                        <b-col lg="auto">
                            <b-button @click="add(info.id)" type="button" size="sm" variant="primary">Add Sub Allotment</b-button>
                        </b-col>
                    </b-row>
                    <hr class="text-muted" />
                </div>
                <div v-if="info.lists.length > 0" class="col-md-12" data-simplebar style="max-height: 300px;">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th style="width: 30%;">Expense</th>
                                    <th style="width: 30%;" class="text-center">Amount</th>
                                    <th style="width: 30%;" class="text-center">Added By</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="list in info.lists" v-bind:key="list.id">
                                    <td>{{(list.expense) ? list.expense.name : ''}}</td>
                                    <td class="text-center">₱{{formatMoney(list.amount)}}</td>
                                    <td class="text-center">{{list.added_by}}</td>
                                    <td class="text-end">
                                        <b-button  @click="edit(list)" variant="soft-primary" v-b-tooltip.hover title="Edit Allotment" size="sm" class="edit-list"><i class="ri-pencil-fill  align-bottom"></i> </b-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-else class="col-md-12 mt-3">
                    <div class="alert alert-warning" role="alert"><strong>Uh oh, no sub allotments found</strong></div>
                </div>
            </div>
        </b-form>
    </b-modal>
    <Sub :expenses="expenses" ref="sub"/>
</template>

<script>
import Sub from './SubAllotment.vue';
export default {
    components : { Sub },
    props: ['expenses'],
    data() {
        return {
            currentUrl: window.location.origin,
            form: {},
            info: { lists: []},
            showModal: false
        }
    },
    watch: {
        datares: {
            deep: true,
            handler(val = null) {
                if(val != null && val !== ''){
                    this.update(val);
                }
            },
        },
    },
    computed: {
        datares() {
            return this.$page.props.flash.datares;
        },
    },
    methods: {
        set(data) {
            this.info = data;
            this.showModal = true;
        },
        add(id){
            this.$refs.sub.set(id);
        },
        update(data){
            this.info.lists.unshift(data);
            this.$emit('total',data.amount);
        },
        edit(data){
            this.$refs.sub.edit(data);
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
    }
}
</script>
