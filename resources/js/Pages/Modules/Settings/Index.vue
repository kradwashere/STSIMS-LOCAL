<template>
    <Head title="Settings" />
    <PageHeader :title="title" :items="items" />
    <b-row>
        <b-col xxl="4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-1">
                        <div class="flex-grow-1">
                            <h5 class="fs-15 mb-1">{{settings.data.agency.name}}</h5>
                            <p class="text-muted mb-0">{{settings.data.agency.region.name}}, {{settings.data.agency.region.region}}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top border-top-dashed">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h6 class="mb-0">{{settings.data.agency.acronym}}</h6>
                        </div>
                        <div  class="flex-shrink-0 text-danger mb-0">
                            <a class="badge badge-soft-primary" :href="settings.data.agency.website" target="_blank">Visit Website <i class="ri-arrow-right-up-line align-bottom"></i></a>
                        </div>
                    </div>
                </div>
            </div>

             <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0">Year for Academic Year</h5>
                        </div>
                    </div>
                    <div class="mb-2 d-flex">
                        <div class="avatar-xs d-block flex-shrink-0 me-3" style="cursor: pointer;" @click="update(settings.data.year)">
                            <span class="avatar-title rounded-circle fs-16 bg-info">
                                <i class="ri-calendar-todo-line"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Address" v-model="settings.data.year" readonly/>
                    </div>
                </div>
            </div>

            <b-card no-body>
                <b-card-body class="mb-2">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-0">Contact Information</h5>
                        </div>
                        <div class="flex-shrink-0">
                            <b-link @click="create()" href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i
                                    class="ri-add-fill align-bottom me-1"></i> Save</b-link>
                        </div>
                    </div>
                    <p class="text-muted mb-4"> Allow users to update the contact information of the system. </p>
                    <div class="mb-3 d-flex">
                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                            <span class="avatar-title rounded-circle fs-16 bg-danger">
                                <i class="ri-map-pin-fill"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Address" v-model="settings.data.information.address"/>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                            <span class="avatar-title rounded-circle fs-16 bg-warning">
                                <i class="ri-phone-fill"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Telephone" v-model="settings.data.information.telephone"/>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                            <span class="avatar-title rounded-circle fs-16 bg-success">
                                <i class="ri-printer-fill"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Fax" v-model="settings.data.information.fax"/>
                    </div>
                    <div class="d-flex">
                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                            <span class="avatar-title rounded-circle fs-16 bg-primary">
                                <i class="ri-facebook-circle-fill"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Facebook" v-model="settings.data.information.facebook"/>
                    </div>
                </b-card-body>
            </b-card>
        </b-col>
        <b-col xxl="8" order-xxl="0" class="order-first">
            <b-card no-body style="height: calc(100vh - 225px); overflow: auto;">
                <b-card-header>
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <b-link class="nav-link active" data-bs-toggle="tab" href="#signatories" role="tab">
                                <i class="fas fa-home"></i>Signatories
                            </b-link>
                        </li>
                        <li class="nav-item">
                            <b-link class="nav-link" data-bs-toggle="tab" href="#settings" role="tab">
                                <i class="fas fa-home"></i>Settings
                            </b-link>
                        </li>
                    </ul>
                </b-card-header>
                <b-card-body>
                    <div class="tab-content">
                        <div class="tab-pane active" id="signatories" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 30%;">Role</th>
                                            <th style="width: 30%;">Signatory</th>
                                            <th class="text-center" style="width: 20%;">Position</th>
                                            <th class="text-center" style="width: 20%;">Date Assigned</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(list,index) in settings.data.signatories" v-bind:key="index">
                                            <td>{{list.role}}</td>
                                            <td v-if="list.name != ''"> 
                                                <img src="/img/avatar-1.7e66bd07.jpg" alt="" class="avatar-xs rounded-circle me-2">
                                                <a href="#javascript: void(0);" class="text-body fw-medium">Donald Risher</a>
                                            </td>
                                            <td v-else>
                                                <code>Not set</code>
                                            </td>
                                            <td class="text-center" v-if="list.position != ''"> 
                                                {{ list.position }}
                                            </td>
                                            <td class="text-center" v-else>
                                                <code>-</code>
                                            </td>
                                             <td class="text-center" v-if="list.date != ''"> 
                                                {{ list.date }}
                                            </td>
                                            <td class="text-center" v-else>
                                                <code>-</code>
                                            </td>
                                            <td>
                                                <button @click="signatory(list.role)" class="btn btn-success btn-sm" type="button">
                                                    <div class="btn-content">Change</div>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="settings" role="tabpanel">
                            settings
                        </div>
                    </div>
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>
    <Year ref="year"/>
    <Signatory ref="signatory"/>
</template>
<script>
import _ from 'lodash';
import Year from './Modals/Year.vue';
import Signatory from './Modals/Signatory.vue';
import PageHeader from "@/Shared/Components/PageHeader.vue";
export default {
    components: { PageHeader, Year, Signatory },
    props: ['settings'],
    data() {
        return {
            currentUrl: window.location.origin,
            title: "Settings",
            items: [{text: "Settings",href: "/",}, {text: "Configuration",active: true, }, ],
        };
    },
    methods: {
        create(){
            this.form = this.$inertia.form({
                id: this.settings.data.id,
                year: this.settings.data.year,
                information: JSON.stringify(this.settings.data.information),
                signatories: JSON.stringify(this.settings.data.signatories)
            })

            this.form.put('/settings/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    
                },
            });
        },
        update(data){
            this.$refs.year.show(data);
        },
        signatory(data){
            this.$refs.signatory.show(data);
        }
    }
}
</script>
<style>
    .file-manager-sidebar {
        min-width: 450px;
        max-width: 450px;
        height: calc(100vh - 180px);
    }
    .dropdown-menu-lg {
        width: 89%;
    }
</style>
