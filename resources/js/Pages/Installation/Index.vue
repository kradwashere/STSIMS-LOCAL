<template>
<Head title="Installation"></Head>
    <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
        <div class="text-center mb-2 text-muted">
            <a to="/" class="d-block auth-logo">
                <img src="/images/logo-dost.png" alt="" height="20" class="auth-logo-dark mx-auto" />
            </a>
            <p class="font-size-11 mt-3">Department of Science & Technology <br> Scholarship Information Management System</p>
            <div id="v-2-2-3">
                <h4 class="mb-4">
                    <span class="text-primary">STSIMS v1.0.0</span>
                    <small class="text-muted font-size-14"> - Installation </small>
                </h4>
            </div>
        </div>
        <div class="mb-4" style="width: 700px;">
            <div class="">
                <div class="table-responsive">
                    <table class="table table-nowrap table-centered table-hover mb-0 align-middle">
                        <tbody>
                            <tr>
                                <td style="width: 45px;">
                                    <div class="avatar-sm">
                                        <span class="avatar-title rounded-circle bg-soft bg-primary text-primary font-size-24">
                                            <i class="bx bx-map"></i>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="font-size-13 mb-0"><a  class="text-dark">Philippine Standard Geographic Code</a></h5>
                                    <small  v-for="(address,name,index) in addresses" v-bind:key="index" ><span v-if="index != 0">,</span> {{name}} : {{address.count }}</small>
                                </td>
                                <td>
                                    <div class="text-center" v-if="!downloaded1">
                                        <button v-if="r" @click="downloadRegion" type="button" class="btn btn-sm btn-label btn-primary"><i class="bx bx-download label-icon"></i> Download </button>
                                        <button v-else type="button" class="btn btn-sm btn-label btn-warning"><i class="bx bx-loader-circle bx-spin label-icon"></i> Downloading </button>
                                    </div>
                                    <div class="text-center" v-else>
                                       <span class="badge bg-success">Downloaded</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="avatar-sm">
                                        <span class="avatar-title rounded-circle bg-soft bg-primary text-primary font-size-24">
                                            <i class="bx bx-list-ul"></i>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="font-size-14 mb-0"><a href="javascript: void(0);" class="text-dark">Lists of tables</a></h5>
                                    <small  v-for="(list,name,index) in lists" v-bind:key="index" ><span v-if="index != 0">,</span> {{name}} : {{list.count }} </small>
                                </td>
                                <td>
                                    <div class="text-center" v-if="!downloaded2">
                                        <button v-if="l" :disabled="low" @click="downloadLists" type="button" class="btn btn-sm btn-label btn-primary"><i class="bx bx-download label-icon"></i> Download </button>
                                        <button v-else type="button" class="btn btn-sm btn-label btn-warning"><i class="bx bx-loader-circle bx-spin label-icon"></i> Downloading </button>
                                    </div>
                                    <div class="text-center" v-else>
                                       <span class="badge bg-success">Downloaded</span>
                                    </div>
                                </td>
                            </tr>
                             <tr>
                                <td>
                                    <div class="avatar-sm">
                                        <span class="avatar-title rounded-circle bg-soft bg-primary text-primary font-size-24">
                                            <i class="bx bxs-school"></i>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="font-size-14 mb-0"><a href="javascript: void(0);" class="text-dark">Lists of Schools</a></h5>
                                    <small  v-for="(list,name,index) in lists" v-bind:key="index" ><span v-if="index != 0">,</span> {{name}} : {{list.count }} </small>
                                </td>
                                <td>
                                    <div class="text-center" v-if="!downloaded3">
                                        <button v-if="s" :disabled="low" @click="downloadSchools" type="button" class="btn btn-sm btn-label btn-primary"><i class="bx bx-download label-icon"></i> Download </button>
                                        <button v-else type="button" class="btn btn-sm btn-label btn-warning"><i class="bx bx-loader-circle bx-spin label-icon"></i> Downloading </button>
                                    </div>
                                    <div class="text-center" v-else>
                                       <span class="badge bg-success">Downloaded</span>
                                    </div>
                                </td>
                            </tr>
                        
                        </tbody>
                    </table>
                </div>
                <center>
                    <button @click="proceed" v-if="show" type="button" class="mt-4 mb-4 btn w-lg btn-primary">Proceed</button>
                </center>
            </div>
        </div>
        <div class="text-center">
            <div>
                <p>© DOST-STSIMS <i class='bx bxs-heart text-danger'></i> 2021</p>
            </div>
        </div>
    </div>
    <Loading :active="isLoading"  :can-cancel="true"  :on-cancel="onCancel"  loader="dots" background-color="black" :is-full-page="fullPage"></Loading>
</template>
<script>
import { Inertia } from '@inertiajs/inertia';
import Loading from 'vue3-loading-overlay';
export default {
    components : { Loading },
    layout: null,
    props: ['id'],
    data(){
        return {
            currentUrl: window.location.origin,
            addresses : [],
            regions: [],
            agencies: [],
            schools: [],
            isLoading: false,
            fullPage: true,
            lists : [],
            low : true,
            show : false,
            r: true,
            l: true,
            s: true,
            downloaded1: false,
            downloaded2: false,
            downloaded3: false,
            form: this.$inertia.form({
                id: '',
                is_active: 1,
                editable: true
            }),
        }
    },

    created(){
        this.fetchLocations();
        this.fetchLists();
    },

    methods : {
        settings() {
            this.isLoading = true;
            axios.get(this.currentUrl + '/sync/settings')
            .then(response => {
                this.isLoading = false;
            })
            .catch(err => console.log(err));
        },


        fetchLocations() {
            this.isLoading = true;
            axios.get(this.currentUrl + '/sync/addresses/check/all')
            .then(response => {
                this.isLoading = false;
                this.addresses = response.data;
            })
            .catch(err => console.log(err));
        },

        downloadRegion() {
            this.isLoading = true; 
            this.r = false;
            let category = 'Regions';
        
            axios.get(this.currentUrl + '/sync/addresses/download/all')
            .then(response => {
                this.isLoading = false;
                this.low = false;
                this.r = true;
                this.downloaded1 = true;
            })
            .catch(err => console.log(err));
        },

        fetchLists() {
            axios.get(this.currentUrl + '/sync/lists/check/all')
            .then(response => {
                this.lists = response.data;
            })
            .catch(err => console.log(err));
        },

         downloadLists() {
            this.l = false;
            axios.get(this.currentUrl + '/sync/lists/download/all')
            .then(response => {
                this.l = true;
                this.downloaded2 = true;
                this.fetchLists();

            })
            .catch(err => console.log(err));
        },

        downloadSchools(category, index) {
            this.s = false;
            axios.get(this.currentUrl + '/sync/schools/download/local')
            .then(response => {
                this.s = true;
                this.show = true;
                this.downloaded3 = true;
            })
            .catch(err => console.log(err));
        },

        proceed()
        {
            // console.log(this.$page.props.auth.data.id);
            this.form.id = this.$page.props.auth.data.id;
            this.form.put('/staffs/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$inertia.get('/home');
                }
            });
        }
    }
}
</script>
