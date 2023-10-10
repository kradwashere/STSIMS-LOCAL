<template>
    <b-modal v-model="showModal" title="Termination" :hide-footer="(viewScholar) ? false : true " style="--vz-modal-width: 700px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered>    
        <template v-if="viewScholar == false">
            <input class="form-control mb-3" v-model="keyword" v-if="scholars != 0" type="text" placeholder="Search Scholar">
            <hr class="text-muted"/>
            <div class="table-responsive">
                <table class="table table-bordered table-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fs-11">
                            <th class="text-center">#</th>
                            <th>Name</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">Level</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody v-if="keyword != ''">
                        <tr v-for="(list,index) in filteredArray" v-bind:key="list.id" class="fs-11" @click="view(list)">
                            <td class="text-center">{{index + 1}}</td>
                            <td>
                                <h5 class="fs-11 mb-0 text-dark">{{ list.scholar.firstname }} {{ list.scholar.lastname }}</h5>
                            </td>
                            <td class="text-center">{{list.semester}} <span class="text-muted fs-11"> ({{list.academic_year}})</span></td>
                            <td class="text-center">{{list.level}}</td>
                            <td class="text-center">
                                <span :class="'badge bg-secondary bg-'+list.status.color">{{list.status.name}}</span>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr v-for="(list,index) in paginatedData" v-bind:key="list.id" class="fs-11" @click="view(list)">
                            <td class="text-center">{{index + 1}}</td>
                            <td>
                                <h5 class="fs-11 mb-0 text-dark">{{ list.scholar.firstname }} {{ list.scholar.lastname }}</h5>
                            </td>
                            <td class="text-center">{{list.semester}}<span class="text-muted fs-11"> ({{list.academic_year}})</span></td>
                            <td class="text-center">{{list.level}}</td>
                            <td class="text-center">
                                <span :class="'badge bg-secondary bg-'+list.status.color">{{list.status.name}}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- <ul class="list-group list-group-flush border-dashed mb-0" v-if="keyword != ''">
                <li class="list-group-item d-flex align-items-center" v-for="(user, index) of  filteredArray" :key="index">
                    <div class="flex-shrink-0">
                        <img :src="currentUrl+'/images/avatars/'+user.scholar.avatar" class="rounded-circle avatar-xs" alt="" />
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="fs-13 mb-0">{{ user.scholar.firstname }} {{ user.scholar.lastname }}</h6>
                        <p class="text-muted fs-12 mb-0">{{user.scholar.spas_id}}</p>
                    </div>
                    <div class="flex-shrink-0 text-end">
                        <button class="btn btn-warning btn-sm  w-100" type="button">
                            <div class="btn-content"><i class="ri-error-warning-fill align-bottom me-1"></i> View</div>
                        </button>
                    </div>
                </li>
            </ul>
            <ul class="list-group list-group-flush border-dashed mb-0" v-else>
                <li class="list-group-item d-flex align-items-center" v-for="(user, index) of  paginatedData" :key="index">
                    <div class="flex-shrink-0">
                        <img :src="currentUrl+'/images/avatars/'+user.scholar.avatar" class="rounded-circle avatar-xs" alt="" />
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="fs-13 mb-0">{{ user.scholar.firstname }} {{ user.scholar.lastname }}</h6>
                        <p class="text-muted fs-12 mb-0">{{user.scholar.spas_id}}</p>
                    </div>
                    <div class="flex-shrink-0 text-end">
                        <button @click="view(user)" class="btn btn-warning btn-sm  w-100" type="button">
                            <div class="btn-content"><i class="ri-error-warning-fill align-bottom me-1"></i> View</div>
                        </button>
                    </div>
                </li>
            </ul> -->
            <hr class="text-muted"/>
            <nav aria-label="Page navigation example" v-if="scholars.length != 0">
                <ul class="pagination justify-content-center">
                    <li class="page-item" :class="(currentPage === 1) ? 'disabled' : ''">
                        <button class="page-link" @click="previousPage" :disabled="currentPage === 1" tabindex="-1">Previous</button>
                    </li>
                    <li class="page-item" v-for="pageNumber in totalPages" :key="pageNumber" :class="{ active: pageNumber === currentPage }">
                        <a class="page-link"  @click="gotoPage(pageNumber)">{{pageNumber}}</a>
                    </li>
                    <li class="page-item" :class="(currentPage === totalPages) ? 'disabled' : ''">
                        <button class="page-link" @click="nextPage">Next</button>
                    </li>
                </ul>
            </nav>
        </template>
        <template v-else>
            <ul class="list-unstyled mb-0 vstack gap-3" v-if="scholar">
                <li>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0" v-if="scholar.scholar.avatar">
                            <img :src="currentUrl+'/images/avatars/'+scholar.scholar.avatar" alt="" class="avatar-sm rounded">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-1 text-primary"> {{scholar.scholar.firstname}} {{scholar.scholar.lastname}}</h6>
                            <span :class="'badge bg-secondary bg-'+scholar.status.color">{{scholar.status.name}}</span>
                        </div>
                    </div>
                </li>
                <hr class="text-muted mt-0" />
            </ul>
            <div class="table-responsive">
                <table class="table table-bordered table-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fs-11">
                            <th class="text-center">#</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Subject</th>
                            <th class="text-center">Unit</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(list,index) in scholar.subjects" v-bind:key="list.id" class="fs-11">
                            <td class="text-center">{{index + 1}}</td>
                            <td class="text-center">
                                <h5 class="fs-11 mb-0 text-dark">{{list.code}}</h5>
                            </td>
                            <td class="text-center">{{list.subject}}</td>
                            <td class="text-center">{{list.unit}}</td>
                            <td class="text-center">
                                <span class="badge bg-danger">Failed</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr class="text-muted"/>
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" v-model="option" value="1" id="1">
                <label class="form-check-label" for="1">Mark as Checked <span class="fs-11 text-muted">(This will hide from the list of termination)</span></label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" v-model="option" value="2" id="2">
                <label class="form-check-label" for="2"> Mark as Suspended only</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" v-model="option" value="3" id="3">
                <label class="form-check-label" for="3"> Terminate Scholar</label>
            </div>
        </template>
        <template v-slot:footer>
            <b-button @click="viewScholar = false" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="(option) ? false : true " block>Confirm</b-button>
        </template>
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                showModal: false,
                scholars: [],
                scholar: '',
                itemsPerPage: 5,
                currentPage: 1,
                filteredArray: [],
                keyword: '',
                option: '',
                viewScholar: false
            }
        },
        watch: {
            keyword(newVal){
                this.search(newVal)
            }
        },
        computed: {
            totalPages() {
                return (this.scholars) ? Math.ceil(this.scholars.length / this.itemsPerPage) : '';
            },
            paginatedData() {
                const start = (this.currentPage - 1) * this.itemsPerPage;
                const end = start + this.itemsPerPage;
                return this.scholars.slice(start, end);
            },
        },
        methods: {
            show(data) {
                this.viewScholar = false;
                this.scholars = data;
                this.showModal = true;
            },
            nextPage() {
                if (this.currentPage < this.totalPages) {
                    this.currentPage++;
                }
            },
            previousPage() {
                if (this.currentPage > 1) {
                    this.currentPage--;
                }
            },
            gotoPage(pageNumber) {
                if (pageNumber >= 1 && pageNumber <= this.totalPages) {
                    this.currentPage = pageNumber;
                }
            },
            search(data) {
                this.filteredArray = this.scholars.filter(item =>
                    item.scholar.lastname.toLowerCase().includes(data.toLowerCase())
                );
            },
            view(data){
                this.scholar= data;
                this.viewScholar = true;
            },
            hide(){
                this.showModal = false;
            }
        }
    }
</script>
