<template>
    <b-modal v-model="showModal" title="Create Reimbursement" style="--vz-modal-width: 600px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2 mt-2">
            <div class="row">
                <div class="col-md-12 mb-0">
                    <form class="app-search d-none d-md-block" style="margin-top: -12px;">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search scholar..." autocomplete="off" id="search-options" />
                            <span class="mdi mdi-magnify search-widget-icon"></span>
                            <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                        </div>
                        <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                            <SimpleBar data-simplebar style="max-height: height: calc(100vh/2 - 326px)">
                                <div class="notification-list">
                                    <b-link @click="choose(list)" v-for="(list, index) of names" :key="index" class="d-flex dropdown-item notify-item py-2">
                                        <img :src="currentUrl+'/images/avatars/'+list.profile.avatar" class="me-3 rounded-circle avatar-xs" alt="user-pic" />
                                        <div class="flex-1">
                                            <h6 class="m-0">{{ list.profile.name}}</h6>
                                            <span class="fs-11 mb-0 text-muted">{{list.program.name}}</span>
                                        </div>
                                    </b-link>
                                </div>
                            </SimpleBar>
                        </div>
                    </form>
                    <ul class="list-unstyled mb-0 vstack gap-3 mb-3" v-if="reimbursement.scholar">
                        <li>
                            <hr class="mt-0 text-muted"/>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img :src="currentUrl+'/images/avatars/'+reimbursement.scholar.profile.avatar" alt="" class="avatar-sm rounded">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <button @click="clear()" class="btn btn-outline-danger btn-sm bg-gradient waves-effect waves-light float-end mt-n1" type="button">
                                        <div class="btn-content"> Change scholar</div>
                                    </button>
                                    <h6 class="fs-14 mb-1 text-primary">{{reimbursement.scholar.profile.name}}</h6>
                                    <span :class="'badge bg-secondary bg-'+reimbursement.scholar.status.color">{{reimbursement.scholar.status.name}}</span>
                                </div>
                            </div>
                             <hr class="mt-3 text-muted"/>
                        </li>
                    </ul>
                </div>
                <div class="col-md-12 mb-3" v-if="reimbursement.scholar">
                    <div class="form-group">
                    <label>AY/Semester: <span v-if="errors" v-text="errors.school_semester_id" class="haveerror"></span></label>
                    <Multiselect
                        v-model="reimbursement.semester" 
                        id="ajax"  track-by="id"
                        placeholder="Search Semester" 
                        open-direction="bottom" 
                        :options="semesters"
                        :searchable="true" 
                        :allow-empty="false"
                        :custom-label="nameWithLang"
                        :show-labels="false"/>
                    </div>
                </div>
                <div class="col-md-12 mb-3" v-if="reimbursement.scholar">
                    <div class="form-group">
                        <label>Privilege: <span v-if="errors" v-text="errors.benefit_id" class="haveerror"></span></label>
                        <Multiselect 
                        v-model="reimbursement.privilege" 
                        :options="lists"
                        :allow-empty="true"
                        :show-labels="false"
                        label="name" track-by="id"
                        placeholder="Select Privilege"/>
                    </div>
                </div>
                <div class="col-md-12 mb-2" v-if="reimbursement.scholar">
                    <div class="form-group">
                        <label>Amount: <span v-if="errors" v-text="errors.amount" class="haveerror"></span></label>
                        <Amount @amount="amount" ref="testing" :readonly="false"/>
                    </div>
                </div>
                <div class="col-md-12" v-if="reimbursement.scholar">
                    <div class="form-group">
                        <label>Remarks: <span v-if="errors" v-text="errors.remarks" class="haveerror"></span></label>
                        <input type="text" class="form-control" v-model="reimbursement.remarks">
                    </div>
                </div>
                <div class="col-md-12 mt-2" v-if="reimbursement.scholar">
                    <input multiple class="mt-2 mb-1" type="file" :class="[($page.props.errors['files.'+0]) ? 'text-danger' : '']" @change="uploadFieldChange">
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="showModal = false" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary"  block>Save</b-button>
        </template>
    </b-modal>
</template>
<script>
import {VMoney} from 'v-money'
import { SimpleBar } from "simplebar-vue3";
import Amount from "@/Shared/Components/Amount.vue";
import Multiselect from '@suadelabs/vue3-multiselect';
export default {
    directives: {money: VMoney},
    props: ['privileges'],
    components : { Multiselect, SimpleBar, Amount },
    data() {
        return {
            currentUrl: window.location.origin,
            reimbursement: {
                privilege: '',
                semester: '',
                amount: '',
                scholar: '',
                remarks: '',
                files: []
            },
            form: {},
            semesters: [],
            showModal: false,
            keyword: '',
            names: [],
            errors: []
        }
    },
    computed: {
        lists : function() {
            return this.privileges.filter(x => x.is_reimburseable === 1);
        },
    },
    mounted() {
        this.isCustomDropdown();
    },
    methods: {
        set() {
            this.showModal = true;
        },
        amount(val){
            this.reimbursement.amount = val;
        },
        nameWithLang ({ academic_year,semester }) {
            return `${academic_year} — ${semester}`
        },
        choose(data){
            this.reimbursement.scholar = data;
            this.semesters = data.semesters;
        },
        checkSearchStr: _.debounce(function (string) {
            this.keyword = string;
            this.search();
        }, 1000),
        search(){
            axios.get('/reimbursements', {
                params: {
                    keyword: this.keyword,
                    search: true
                }
            })
            .then(response => {
                if (response) {
                    this.names = response.data.data;
                    this.$emit('info',true);
                }
            })
            .catch(err => console.log(err));
        },
        uploadFieldChange(e) {
            e.preventDefault();
            var files = e.target.files || e.dataTransfer.files;

            if (!files.length)
                return;
            for (var i = files.length - 1; i >= 0; i--) {
                this.reimbursement.files.push(files[i]);
            }
        },
        create(){
            let data = new FormData();
            if(this.reimbursement.files.length > 0){
                for (var i = this.reimbursement.files.length - 1; i >= 0; i--) {
                    data.append('files[]', this.reimbursement.files[i]);
                }
            }else{
                data.append('files[]', '');
            }
            data.append('school_semester_id',(this.reimbursement.semester) ? this.reimbursement.semester.id : '');
            data.append('scholar_id',(this.reimbursement.scholar) ? this.reimbursement.scholar.id : '');
            data.append('benefit_id',(this.reimbursement.privilege) ? this.reimbursement.privilege.id : '');
            data.append('amount',this.reimbursement.amount);
            data.append('remarks',this.reimbursement.remarks);
            data.append('is_reimbursed',1);

            this.$inertia.post('/reimbursements', data, {
                preserveScroll: true,
                forceFormData: true,
                onSuccess: (response) => {
                    this.showModal = false;
                    this.clear();
                },
                onError: () => {
                    this.errors = this.$page.props.errors;
                }
            });
        },
        clear(){
            var searchInput = document.getElementById("search-options");
            searchInput.value = '';
            this.reimbursement.scholar = '';
            this.reimbursement.amount = '';
            this.reimbursement.files = [];
            this.reimbursement.remarks = '';
            this.reimbursement.semester = '';
            this.reimbursement.privilege = '';
            this.semesters = [];
            this.isCustomDropdown();
        },
        isCustomDropdown() {
            var searchOptions = document.getElementById("search-close-options");
            var dropdown = document.getElementById("search-dropdown");
            var searchInput = document.getElementById("search-options");

            searchInput.addEventListener("focus", () => {
                var inputLength = searchInput.value.length;
                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchInput.addEventListener("keyup", () => {
                var inputLength = searchInput.value.length;
                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");
                    this.checkSearchStr(searchInput.value);
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchOptions.addEventListener("click", () => {
                searchInput.value = "";
                dropdown.classList.remove("show");
                searchOptions.classList.add("d-none");
            });

            document.body.addEventListener("click", (e) => {
                if (e.target.getAttribute("id") !== "search-options") {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });
        },
    }
}
</script>
<style>
.multiselect, .multiselect__input, .multiselect__single {
  font-size: 13px;
}
.multiselect__placeholder {
  font-size: 13px;
}
.dropdown-menu-lg {
    width: 95%;
}
</style>