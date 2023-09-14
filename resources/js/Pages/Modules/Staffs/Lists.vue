<template>
    <b-row class="g-2 mb-2 mt-n1">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="keyword" placeholder="Search Staff" class="form-control" style="width: 30%;">
                <select v-model="role" @change="fetch()" class="form-select" id="inputGroupSelect01" style="width: 120px;">
                    <option :value="null" selected>Select Role</option>
                    <option :value="list" v-for="(list,index) in roles" v-bind:key="index">{{list}}</option>
                </select>
                <span @click="refresh" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                    <i class="bx bx-refresh search-icon"></i>
                </span>
                <b-button type="button" variant="primary" @click="create()">
                    <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                </b-button>
            </div>
        </b-col>
    </b-row>
    <div class="table-responsive">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th></th>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 15%;" class="text-center">Assigned</th>
                    <th style="width: 15%;" class="text-center">Email</th>
                    <th style="width: 15%;" class="text-center">Mobile</th>
                    <th style="width: 15%;" class="text-center">Status</th>
                    <th style="width: 10%;"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(list,index) in lists" v-bind:key="index" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                    <td>
                        <div class="avatar-xs chat-user-img online">
                            <span v-if="list.avatar == 'avatar.jpg'" :class="'avatar-title rounded-circle bg-primary text-white'">{{list.lastname[0]}}</span>
                            <img v-else :src="currentUrl+'/images/avatars/'+list.avatar" alt="" class="avatar-xs rounded-circle">
                            <span v-if="list.is_active" class="user-status text-success"></span>
                        </div>
                    </td>
                    <td>
                        <h5 class="fs-13 mb-0 text-dark">{{list.profile.name}}</h5>
                        <p class="fs-12 text-muted mb-0">{{list.role}}</p>
                    </td>
                    <td class="text-center">{{list.profile.type.name}}</td>
                    <td class="text-center">{{list.email}}</td>
                    <td class="text-center">{{list.profile.mobile}}</td>
                    <td class="text-center">
                        <span v-if="list.is_active" class="badge bg-success">Active</span>
                        <span v-else class="badge bg-danger">Inactive</span>
                    </td>
                    <td class="text-end">
                        <b-button variant="soft-success" @click="update('status',list,index)" v-b-tooltip.hover title="Lock" size="sm" class="remove-list me-1">
                            <i class="ri-lock-2-fill align-bottom"></i>
                        </b-button>
                        <b-button variant="soft-warning"  @click="update('verification',list,index)" v-b-tooltip.hover title="Verify" size="sm" class="remove-list me-1">
                            <i class="ri-mail-send-fill align-bottom"></i>
                        </b-button>
                        <b-button @click="edit(list,index)" variant="soft-primary" v-b-tooltip.hover title="Edit" size="sm" class="edit-list">
                            <i class="ri-pencil-fill align-bottom"></i>
                        </b-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
    <Create ref="create"/>
    <Update ref="update"/>
</template>
<script>
import Update from './Modals/Update.vue';
import Create from './Modals/Create.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components : { Pagination, Create, Update },
    data(){
        return {
            currentUrl: window.location.origin,
            lists : [],
            meta: {},
            links: {},
            index: '',
            role: null,
            keyword: '',
            roles: [
                'Regional Director', 
                'Accountant', 
                'Scholarship Coordinator', 
                'Scholarship Staff',
                'University Coordinator',
                'PSTO Staff'
            ],
            type: ''
        }
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
                    switch(this.type){
                        case 'create':
                            this.fetch();
                        break;
                        case 'edit':
                            this.lists[this.index] = val.data;
                        break;
                    }
                }
            },
        },
        keyword(newVal){
            this.checkSearchStr(newVal)
        },
    },
    created(){
        this.fetch();
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url){
            page_url = page_url || '/staffs';
            axios.get(page_url,{
                params : {
                    keyword : this.keyword,
                    role: this.role,
                    counts: ((window.innerHeight-350)/56),
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
        create(){
            this.type = 'create';
            this.$refs.create.show();
        },
        edit(data,index){
            this.type = 'edit';
            this.index = index;
            this.$refs.create.edit(data);
        },
        update(type,data,index){
            this.type = 'edit';
            this.index = index;
            this.$refs.update.show(type,data);
        },
        refresh(){
            this.role = null;
            this.keyword = '';
            this.fetch();
        }
    }
}
</script>