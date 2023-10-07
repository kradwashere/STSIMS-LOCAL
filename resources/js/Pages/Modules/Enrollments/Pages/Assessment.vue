<template>
    <b-row class="mb-3 mt-n2">
        <div class="col-md-6">
            <div class="page-title-left mt-2">
                <ol class="breadcrumb m-0 fs-15">
                    <li class="breadcrumb-item fw-bold">{{ selected.academic_year }}</li>
                    <li class="breadcrumb-item active"><span>{{selected.level }}</span></li>
                    <li class="breadcrumb-item active"><span class="fw-bold text-primary">{{selected.semester }}</span></li>
                </ol>
            </div> 
        </div>
        <div class="col-md-6">
            <div class="hstack float-end gap-2 mt-4 mt-sm-0">
                <button v-if="selected.is_locked == 0" @click="locked(selected)" :disabled="!selected.is_clear" v-b-tooltip.hover title="Lock" class="btn btn-primary btn-md float-end me-0" type="button">
                    <div class="btn-content"><i class="bx bxs-lock-alt"></i></div>
                </button>
                <button v-if="selected.is_locked == 0" @click="save()" class="btn btn-success btn-md btn-label" type="button">
                    <div class="btn-content"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Save </div>
                </button>
                 <button v-else @click="locked(selected)" class="btn btn-danger btn-md btn-label" type="button" v-b-tooltip.hover title="Scholarship Coordinator Only">
                    <div class="btn-content"><i class="ri-lock-unlock-fill label-icon align-middle fs-16 me-2" ></i> Unlock </div>
                </button>
            </div>
        </div>
    </b-row>
    <hr />
    <div class="todo-content position-relative px-4 mx-n4" id="todo-content">
        <div class="col-md-12" style="overflow: auto;">
            <div class="table-responsive">
                <table class="table table-centered table-bordered table-nowrap mb-0">
                    <thead class="thead-light">
                        <tr class="font-size-11">
                            <th style="width: 5%;" class="text-center">#</th>
                            <th style="width: 15%;" class="text-center">Code</th>
                            <th class="text-center" style="width: 63%;">Subject</th>
                            <th class="text-center" style="width: 10%;">Unit</th>
                            <th class="text-center" style="width: 7%;">Grade</th>
                        </tr>
                    </thead>
                </table>
                <SimpleBar class="align-items-center d-flex justify-content-center">
                    <table class="table table-centered table-bordered table-nowrap">
                        <tbody class="fs-12">
                            <tr v-for="(list,index) in lists" v-bind:key="list.id" :class="[(list.is_failed) ? 'table-danger' : '']">
                                <td style="width: 5%;" class="text-center">{{ index+1 }}</td>
                                <td style="width: 15%;" class="text-center fw-bold">{{list.code}} <span v-if="list.is_lab == true" class="text-warning fw-bold">(Lab)</span></td>
                                <td style="width: 63%;" class="text-center">{{list.subject}} <span v-if="list.is_lab == true" class="text-warning fw-bold">(Lab)</span></td>
                                <td style="width: 10%;" class="text-center">{{list.unit}}</td>
                                <td style="width: 7%;" class="text-center">
                                    <select  v-model="list.grade" v-if="selected.is_locked == 0" class="form-select form-select-sm mt-n1 mb-n1" style="">
                                        <option :value="null" disabled>-</option>
                                        <option :value="list1.grade" v-for="(list1,index) in gradings" v-bind:key="index">{{list1.grade}}</option>
                                    </select>
                                    <span class="fw-semibold" v-else>{{list.grade}}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </SimpleBar>
                <table class="table table-centered table-bordered table-nowrap mt-n3 mb-0">
                    <tfoot class="thead-light">
                        <tr class="font-size-12">
                            <th style="width: 80%;" colspan="3"></th>
                            <th class="text-center text-primary" style="width: 10%;">{{ units }}</th>
                            <th class="text-center text-primary" style="width: 10%;">{{ total }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <Lock :lists="lists" @status="message" ref="lock"/>
    <Confirm ref="confirm"/>
</template>
<script>
import Lock from '../Modals/Lock.vue';
import Confirm from '../Modals/ConfirmGrade.vue';
import { SimpleBar } from 'simplebar-vue3';
export default {
    components: { SimpleBar, Confirm, Lock },
    props: ['selected','user','gradings'],
    data() {
        return {
            currentUrl: window.location.origin,
            errors: [],
            attachments: [],
            lists: [],
            type: null,
        }
    },
    watch: {
        data: {
            deep: true,
            handler(val = null) {
                if(val != null && val !== ''){
                    this.message(val.data);
                }
            },
        },
    },
    computed: {
        units: function () {
            var sum = 0;
            if(this.lists != undefined){
                this.lists.forEach(e => {
                    sum += Number(e.unit);
                });
            }
            return sum
        },
        total: function () {
            var sum = 0; var tot = 0;
            if(this.lists != undefined){
                this.lists.forEach(e => {
                    if(e.is_nonacademic == false){
                        tot++;
                        if(e.grade == 'F' || e.grade == 'f'){

                        }else{
                            sum += Number(e.grade);
                        }
                    }
                });
            }
            return (sum/tot).toFixed(3);
            this.$forceUpdate();
        },
        failed: function(){
            var count = 0;
            this.lists.forEach(e => {
                if(e.grade == 'F' || e.grade == 'f' || e.grade > 3){
                    count = count + 1;
                }
            });
            return count;
        },
        data() {
            return this.$page.props.flash.data;
        },
    },

    methods: {
        uploadFieldChange(e) {
            e.preventDefault();
            var files = e.target.files || e.dataTransfer.files;

            if (!files.length)
                return;
            for (var i = files.length - 1; i >= 0; i--) {
                this.attachments.push(files[i]);
            }
        },

        save() {
            this.type = 'save';
            let data = new FormData();
            data.append('enrollment_id', (this.selected != undefined) ? this.selected.id : '');
            data.append('scholar_id', (this.user != undefined) ? this.user : '');
            data.append('lists', (this.lists.length != 0) ? JSON.stringify(this.lists) : '');
            data.append('file_type', 'grade');
            data.append('type', 'grade');

            this.$refs.confirm.set(data);
        },
        locked(id){
            this.type = 'lock';
            this.$refs.lock.set(id);
        },
        message(list){
            this.selected.is_locked = list.is_locked;
            this.selected.is_clear = list.is_clear;
            if(this.type == 'lock'){
                this.$emit('status', list);  
            }
        },
        back(){
            this.$parent.set('prospectus');
        },
        set(lists){
            this.lists = lists;
        }
    }
}
</script>
<style>
    .todo-content {
        height: calc(100vh - 280px);
    }
    .multiselect__single {
        font-size: 12px;
    }
</style>