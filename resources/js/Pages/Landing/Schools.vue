<template>
    <div class="layout-wrapper landing">
        <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
            <b-container>
                <b-link class="navbar-brand" href="/">
                    <img src="/images/logo-dark.png" class="card-logo card-logo-dark" alt="logo dark"
                        height="25">
                    <img src="/images/logo-light.png" class="card-logo card-logo-light" alt="logo light"
                        height="17">
                </b-link>
                <button class="navbar-toggler py-0 fs-20 text-body" type="button" v-b-toggle.navbarSupportedContent>
                    <i class="mdi mdi-menu"></i>
                </button>

                <b-collapse class="navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                        <li class="nav-item">
                            <Link href="/" class="nav-link">Home</Link>
                        </li>
                        <li class="nav-item">
                            <Link href="/search/schools" class="nav-link active">Schools</Link>
                        </li>
                         <li class="nav-item">
                            <Link href="/search/courses" class="nav-link">Courses</Link>
                        </li>
                        <li class="nav-item">
                            <b-link class="nav-link" href="#contact">Contact</b-link>
                        </li>
                    </ul>

                    <div class="">
                        <Link href="/login" class="btn btn-primary">Sign In</Link>
                    </div>
                </b-collapse>
            </b-container>
        </nav>

        <section class="section pb-0 hero-section" id="hero" style="min-height: 500px;">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <b-container>
                <b-row class="justify-content-between align-items-center">
                    <b-col lg="12">
                        <div class="mt-5">
                            <div class="text-center mb-5">
                                <h4 class="mb-2 fw-semibold">Search Schools</h4>
                                <p class="lead text-muted fs-14 mb-4">Search FAAP Accredited Institutions.</p>
                            </div>
                            <!-- <p class="lead fs-12 text-muted lh-base mb-4">Find schools, FAAP Accredited Institutions.</p> -->
                            <form action="#" class="job-panel-filter">
                                <b-row class="g-md-0 g-2">
                                    <b-col md="10">
                                        <div>
                                            <input type="search" v-model="keyword" id="job-title" class="form-control filter-input-box"
                                                placeholder="School name...">
                                        </div>
                                    </b-col>
                                    <b-col md="2">
                                        <div class="h-100">
                                            <b-button variant="primary" class="submit-btn w-100 h-100" type="submit"><i
                                                    class="ri-search-2-line align-bottom me-1"></i> Find School</b-button>
                                        </div>
                                    </b-col>
                                </b-row>
                            </form>

                            <ul class="treding-keywords list-inline mb-0 mt-3 fs-13">
                                <li class="list-inline-item text-danger fw-semibold"><i
                                        class="mdi mdi-tag-multiple-outline align-middle"></i> Trending Keywords:</li>
                                <li class="list-inline-item">
                                    <b-link href="#">Design,</b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="#">Development,</b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="#">Manager,</b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="#">Senior</b-link>
                                </li>
                            </ul>
                        </div>
                    </b-col>
                    
                </b-row>

                <b-row class="mt-3 mt-5 mb-5" v-if="lists.length > 0">
                    <b-col lg="6" v-for="list in lists" v-bind:key="list.id" @click="view(list)">
                        <b-card no-body class="shadow-lg">
                            <b-card-body>
                                <div class="d-flex mb-n3">
                                    <div class="ms-3 flex-grow-1">
                                        <b-link href="#!">
                                            <h5 class="fs-14">{{list.name}} - {{list.campus}}</h5>
                                        </b-link>
                                        <ul class="list-inline text-muted mt-n2 mb-3">
                                            <!-- <li class="list-inline-item">
                                                <i class="ri-building-line align-bottom me-1"></i> Nesta Technologies
                                            </li> -->
                                            <li class="list-inline-item fs-12">
                                                <i class="ri-map-pin-2-fill align-bottom me-1"></i> {{list.address}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </b-card-body>
                        </b-card>
                    </b-col>
                </b-row>
                <b-alert show variant="warning" class="text-center mb-5 mt-5" role="alert" v-else>
                No school found.
                </b-alert>

            </b-container>
        </section>
       

        <section class="py-5 bg-primary position-relative">
            <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
            <b-container>
                <b-row class="align-items-center gy-4">
                    <b-col sm>
                        <div>
                            <h4 class="text-white mb-0 fw-semibold">Be one of our Scholars!</h4>
                        </div>
                    </b-col>
                    <b-col sm="auto">
                        <div>
                            <b-link href="https://1.envato.market/velzon-admin" target="_blank"
                                class="btn bg-gradient btn-danger"><i
                                    class="ri-shopping-cart-2-line align-middle me-1"></i>
                                Apply Now</b-link>
                        </div>
                    </b-col>
                </b-row>

            </b-container>
        </section>

        <footer class="custom-footer bg-dark py-5 position-relative">
            <b-container>
                <b-row>
                    <b-col lg="7" class="mt-4">
                        <div>
                            <div>
                                <img src="images/logo-light.png" alt="logo light" height="25">
                            </div>
                            <div class="mt-4 fs-13">
                                <p>Science & Technology Scholarship Information Management System</p>
                                <p class="ff-secondary">STSIMS (Science & Technology Scholarship Information Management System) envisions to optimize the conduct of scholarship functions, that which in turn will ensure satisfaction among customers both internal and external.</p>
                            </div>
                        </div>
                    </b-col>

                    <b-col lg="5" class="ms-lg-auto">
                        <b-row>
                            <b-col sm="12" class="mt-4 text-end">
                                <h4 class="text-white mb-0">Contact Details</h4>
                                <div class="text-muted mt-4 fs-13">
                                    <ul class="list-unstyled ff-secondary footer-list">
                                        <li>
                                            Department of Science and Technology Regional Office No. IX
                                        </li>
                                        <li>
                                            Pettit Barracks, Barangay Zone IV, Zamboanga City
                                        </li>
                                        <li>
                                            Tel.: (062) 991-1024
                                        </li>
                                        <li>
                                            Fax: (062) 992-1114
                                        </li>
                                    </ul>
                                </div>
                            </b-col>
                            
                            
                        </b-row>
                    </b-col>
                </b-row>

                <b-row class="text-center text-sm-start align-items-center mt-5">
                    <b-col sm="6">

                        <div>
                            <p class="copy-rights mb-0 currentyear">{{ new Date().getFullYear() }} © DOST-IX
                            </p>
                        </div>
                    </b-col>
                    <b-col sm="6">
                        <div class="text-sm-end mt-3 mt-sm-0">
                            <ul class="list-inline mb-0 footer-social-link">
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-facebook-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-github-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-linkedin-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-google-fill"></i>
                                        </div>
                                    </b-link>
                                </li>
                                <li class="list-inline-item">
                                    <b-link href="javascript: void(0);" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="ri-dribbble-line"></i>
                                        </div>
                                    </b-link>
                                </li>
                            </ul>
                        </div>
                    </b-col>
                </b-row>
            </b-container>
        </footer>
        <b-button variant="danger" @click="topFunction" class="btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </b-button>
    </div>
    <School ref="school"/>
</template>

<script>
import School from './Modals/School.vue';
export default { 
    layout: null,
    components : { School },
    data() {
        return {
            keyword: '',
            lists: [],
            meta: {},
            links: {}
        };
    },
    methods: {
        view(data){
            this.$refs.school.show(data);
        },
        topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        },
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url) {
            if(this.keyword != ''){
                page_url = page_url || '/search/schools';
                axios.get(page_url, {
                    params: {
                        keyword: this.keyword,
                        type: 'schools'
                    }
                })
                .then(response => {
                    this.lists = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                })
                .catch(err => console.log(err));
            }else{
                this.lists = [];
            }
        },
    },
    watch: {
        keyword(newVal){
            this.checkSearchStr(newVal)
        }
    },
    mounted() {

        let backtoTop = document.getElementById("back-to-top");

        if (backtoTop) {
            backtoTop = document.getElementById("back-to-top");
            window.onscroll = function () {
                if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                    backtoTop.style.display = "block";
                } else {
                    backtoTop.style.display = "none";
                }
            };
        }

        window.addEventListener('scroll', function (ev) {
            ev.preventDefault();
            var navbar = document.getElementById("navbar");
            if (navbar) {
                if (document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50) {
                    navbar.classList.add("is-sticky");
                } else {
                    navbar.classList.remove("is-sticky");
                }
            }
        });

    },
};
</script>