<template>
    <div class="layout-wrapper landing">
        <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
            <b-container>
                <b-link class="navbar-brand" href="/">
                    <img src="images/logo-dark.png" class="card-logo card-logo-dark" alt="logo dark"
                        height="25">
                    <img src="images/logo-light.png" class="card-logo card-logo-light" alt="logo light"
                        height="17">
                </b-link>
                <button class="navbar-toggler py-0 fs-20 text-body" type="button" v-b-toggle.navbarSupportedContent>
                    <i class="mdi mdi-menu"></i>
                </button>

                <b-collapse class="navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                        <li class="nav-item">
                            <Link href="/" class="nav-link active">Home</Link>
                        </li>
                        <li class="nav-item">
                            <Link href="/search/schools" class="nav-link">Schools</Link>
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

        <section class="section pb-0 hero-section" id="hero" style="height: 500px;">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <b-container>
                <b-row class="justify-content-center">
                    <b-col lg="8" sm="10">
                        <div class="text-center mt-lg-5 pt-5">
                            <h1 class="display-6 fw-semibold mb-3 lh-base">BE A 
                                <span class="text-primary">SCHOLAR </span>
                            </h1>
                            <p class="lead text-muted lh-base">SEI shall have developed the Philippines’ human resource capacity in science and technology required to produce demand-driven outputs that meet global standards. </p>

                            <div class="d-flex gap-2 justify-content-center mt-4">
                                <b-link href="/auth/signin-basic" class="btn btn-primary">Get Started <i
                                        class="ri-arrow-right-line align-middle ms-1"></i></b-link>
                                <router-link to="/pages/pricing" class="btn btn-danger">View Plans <i
                                        class="ri-eye-line align-middle ms-1"></i></router-link>
                            </div>
                        </div>
                    </b-col>
                </b-row>
            </b-container>
            <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
                        <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z">
                        </path>
                    </g>
                </svg>
            </div>
        </section>

        <section id="team" class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card bg-soft bg-light border shadow-none mb-3">
                            <div class="p-1">
                                <div class="d-flex mt-1">
                                    <div class="avatar-xs align-self-center ml-2 ms-2 mr-2">
                                        <div class="avatar-title rounded bg-transparent"><i
                                                class="bx bx-news h4 mt-1"></i></div>
                                    </div>
                                    <div class="overflow-hidden mr-auto align-self-center">
                                        <h5 class="fw-semibold fs-12 mt-1">Announcements</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-sm-6">
                                <div class="blog-box mb-4 mb-xl-0">
                                    <div class="position-relative"><img
                                            src="http://stsims.local/images/post-2.jpg" alt=""
                                            class="rounded img-fluid mx-auto d-block">
                                        <div class="badge bg-success blog-badge fs-11">Announcement</div>
                                    </div>
                                    <div class="mt-4 text-muted fs-12">
                                        <p class="mb-2"><i class="bx bx-calendar me-1"></i> May 14, 2022 6:38 pm
                                        </p>
                                        <h6 class="mb-3 fw-bold">2021 DOST-SEI Undergraduate Scholars</h6>
                                        <p>The long wait is over for the applicants to the 20..</p>
                                        <div><a href="#">Read more</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="blog-box mb-4 mb-xl-0">
                                    <div class="position-relative"><img
                                            src="http://stsims.local/images/post-1.jpg" alt=""
                                            class="rounded img-fluid mx-auto d-block">
                                        <div class="badge bg-success blog-badge fs-11">News</div>
                                    </div>
                                    <div class="mt-4 text-muted fs-12">
                                        <p class="mb-2"><i class="bx bx-calendar me-1"></i> May 14, 2022 5:57 pm
                                        </p>
                                        <h6 class="mb-3 fw-bold">The DOST-SEI is proud to announce the
                                            qualifiers for the 2021 Junior Level Science Scholarships! </h6>
                                        <p>Congratulations, scholars! May your journey as sci..</p>
                                        <div><a href="#">Read more</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="blog-box mb-4 mb-xl-0">
                                    <div class="position-relative"><img
                                            src="http://stsims.local/images/default.jpg" alt=""
                                            class="rounded img-fluid mx-auto d-block">
                                        <div class="badge bg-success blog-badge fs-11">News</div>
                                    </div>
                                    <div class="mt-4 text-muted fs-12">
                                        <p class="mb-2"><i class="bx bx-calendar me-1"></i> May 14, 2022 5:54 pm
                                        </p>
                                        <h6 class="mb-3 fw-bold">STSIMS version 1 released.</h6>
                                        <p>The Science and Technology Scholarship Information..</p>
                                        <div><a href="#">Read more</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card bg-soft bg-light border shadow-none mb-3">
                            <div class="p-1">
                                <div class="d-flex mt-1">
                                    <div class="avatar-xs align-self-center ml-2 ms-2 mr-2">
                                        <div class="avatar-title rounded bg-transparent"><i
                                                class="bx bx-info-circle h4 mt-1"></i></div>
                                    </div>
                                    <div class="overflow-hidden mr-auto align-self-center">
                                        <h5 class="fw-semibold fs-12 mt-1">Quick Links</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card border"><a href="https://www.science-scholarships.ph" target="_blank">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap">
                                        <div class="avatar-sm">
                                            <div class="avatar-title bg-light rounded-circle fs-20 text-primary">
                                                <i class="bx bxs-window-alt"></i>
                                            </div>
                                        </div>
                                        <div class="ms-3 mt-1">
                                            <p class="fw-semibold fs-13 text-truncated mb-0">S&amp;T E-Scholarship </p>
                                            <h5 class="mb-0 text-muted fs-12">Web Application System</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="card border mt-n3">
                            <a href="https://www.sei.dost.gov.ph/images/stsd/ugradFAQ.pdf" target="_blank">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap">
                                        <div class="avatar-sm">
                                            <div
                                                class="avatar-title bg-light rounded-circle font-size-20 text-warning">
                                                <i class="bx bxs-user-voice"></i></div>
                                        </div>
                                        <div class="ms-3 mt-1">
                                            <p class="fw-semibold fs-13 text-truncated text-warning mb-0">Frequently Asked
                                                Questions </p>
                                            <h5 class="mb-0 text-muted fs-12">DOST - Science Education
                                                Institute</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="card border mt-n3">
                            <div class="card-body">
                                <div class="d-flex flex-wrap">
                                    <div class="avatar-sm">
                                        <div
                                            class="avatar-title bg-light rounded-circle font-size-20 text-primary">
                                            <img src="images/sei.png" alt="" class="ms-1" style="width: 25px;">
                                        </div>
                                    </div>
                                    <div class="ms-3 mt-1"><a href="https://www.sei.dost.gov.ph/"
                                            target="_blank">
                                            <p class="fw-semibold fs-13 text-truncated mb-0">Science Education Institute
                                            </p>
                                        </a> <a href="https://www.dost.gov.ph/" target="_blank">
                                            <h5 class="mb-0 text-muted fs-12">Department of Science and
                                                Technology
                                            </h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-group bg-light rounded mb-3"><input type="email"
                                placeholder="Enter Email address" aria-label="Recipient's username"
                                aria-describedby="button-addon2" class="form-control bg-transparent border-0">
                            <div class="input-group-append"><button type="button" id="button-addon2"
                                    class="btn btn-primary rounded"><i class="bx bx-envelope"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                            <b-link target="_blank"
                                class="btn bg-gradient btn-danger">
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
</template>

<script>
export default { 
    layout: null,
    data() {
        return {
            title: "Starter",
            items: [{
                text: "Pages",
                href: "/",
            },
            {
                text: "Starter",
                active: true,
            },
            ],
        };
    },
    methods: {

        topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        },

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