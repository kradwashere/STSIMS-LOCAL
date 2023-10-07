<template>
    <b-modal v-model="showModal" title="Grades" style="--vz-modal-width: 60%;" hide-footer header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered>    
         <b-form class="customform mb-2">
            <b-row class="mt-2 mb-2">
                <b-col lg="4">
                    <div class="p-2 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-success fs-24">
                                    <i class="ri-calendar-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1">Academic Year :</p>
                                <h6 class="mb-0">{{ enrollment.academic_year }}</h6>
                            </div>
                        </div>
                    </div>
                </b-col>
                <b-col lg="4">
                    <div class="p-2 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-success fs-24">
                                    <i class="ri-calendar-todo-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1">Semester :</p>
                                <h6 class="mb-0">{{ enrollment.semester.name }}</h6>
                            </div>
                        </div>
                    </div>
                </b-col>
                <b-col lg="4">
                    <div class="p-2 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-success fs-24">
                                    <i class="ri-archive-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1">Level :</p>
                                <h6 class="mb-0">{{ enrollment.level.name }}</h6>
                            </div>
                        </div>
                    </div>
                </b-col>
            </b-row>
            <div class="row">
                <div class="col-md-12">
                    <hr class="text-muted"/>
                    <div class="table-responsive" style="height: calc(100vh - 600px);">
                        <table class="table table-bordered table-nowrap align-middle mb-0">
                            <thead class="table-dark">
                                <tr class="fs-11">
                                    <th class="text-center">#</th>
                                    <th>Code</th>
                                    <th class="text-center">Subject</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list,index) in enrollment.grades" v-bind:key="list.id">
                                    <td class="text-center">{{index + 1}}</td>
                                    <td>
                                        <h5 class="fs-13 mb-0 text-dark">{{list.code}}</h5>
                                    </td>
                                    <td class="text-center">{{list.subject}}</td>
                                    <td class="text-center">
                                        <span v-if="list.is_failed" class="badge bg-danger">Failed</span>
                                        <span v-else-if="list.grade == null" class="badge bg-warning">Waiting</span>
                                        <span v-else class="badge bg-success">Passed</span>
                                    </td>
                                    <td class="text-center">{{list.unit}}</td>
                                    <td class="text-center">{{list.grade}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row g-2 mt-2" v-if="(enrollment.attachment)">
                <hr class="text-muted"/>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-3 py-2 bg-light mb-0">
                        <li class="breadcrumb-item"><a class="" href="#" target="_self"><i class="ri-attachment-2"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Attachments </li>
                    </ol>
                </nav>
                <div class="col-lg-4">
                    <div class="border rounded border-dashed p-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-light text-info rounded fs-24">
                                        <i class="ri-file-pdf-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="fs-12 mb-1">
                                    <a class="text-body text-truncate d-block" :href="currentUrl+'/storage/'+enrollment.attachment.enrollments.file" target="_blank">{{enrollment.attachment.enrollments.name}}</a>
                                </h5>
                                <div class="fs-11">2.2MB</div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-icon text-muted btn-sm fs-18">
                                        <i class="ri-download-2-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" v-for="(list,index) in enrollment.attachment.grades" v-bind:key="index">
                    <div class="border rounded border-dashed p-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-light text-primary rounded fs-24">
                                        <i class="ri-folder-zip-fill "></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="fs-12 mb-1">
                                    <a class="text-body text-truncate d-block" :href="currentUrl+'/storage/'+list.file" target="_blank">{{list.name}}</a>
                                </h5>
                                <div class="fs-11">2.2MB</div>
                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-icon text-muted btn-sm fs-18">
                                        <i class="ri-download-2-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </b-form>   
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                showModal: false,
                enrollment: {
                    semester: {},
                    level: {},
                    grades: [],
                    attachment: {
                        grades: [],
                        enrollments: []
                    }
                },
            }
        },
        methods: {
            show(data) {
                this.enrollment = data;
                this.showModal = true;
            },
        }
    }
</script>
