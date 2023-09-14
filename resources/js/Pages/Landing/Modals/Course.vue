<template>
   <b-modal v-model="showModal" size="lg" hide-footer title="View Course" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered>    
        <b-col md>
            <b-row class="align-items-center g-3">
                <b-col md>
                    <div>
                        <h5 class="fw-semibold">{{course.name}}</h5>
                    </div>
                </b-col>
            </b-row>
            <hr/>
            <input class="form-control mb-3"  v-model="searchValue" v-if="course.schools.length != 0" type="text" placeholder="Search School">
            

             <b-list-group class="mb-4" v-if="searchValue != ''">
                <b-list-group-item class="list-group-item" v-for="item in filteredArray" :key="item.id">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="d-flex">
                                <div class="flex-shrink-0 ms-2">
                                    <h6 class="fs-14 mb-0">{{item.name}}</h6>
                                    <small class="text-muted">{{item.address}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-list-group-item>
            </b-list-group>

            <b-list-group class="mb-4" v-if="course.schools.length > 0 && searchValue == ''">
                <b-list-group-item class="list-group-item" v-for="item in paginatedData" :key="item.id">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="d-flex">
                                <div class="flex-shrink-0 ms-2">
                                    <h6 class="fs-14 mb-0">{{item.name}}</h6>
                                    <small class="text-muted">{{item.address}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-list-group-item>
            </b-list-group>

            <b-alert show variant="warning" class="text-center" role="alert" v-else>
                No course found.
            </b-alert>


            

            <nav aria-label="Page navigation example" v-if="course.schools.length != 0">
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
        </b-col>
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            course: { schools: []},
            itemsPerPage: 3,
            currentPage: 1,
            filteredArray: [],
            searchValue: ''
        }
    },
    computed: {
        totalPages() {
            return (this.course) ? Math.ceil(this.course.schools.length / this.itemsPerPage) : '';
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.course.schools.slice(start, end);
        },
    },
    methods: {
        show(data){
            this.searchValue=  '';
            this.filteredArray = [];
            this.course = data;
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
            this.filteredArray = this.course.schools.filter(item =>
                item.name.toLowerCase().includes(data.toLowerCase())
            );
        },
    },
    watch: {
        searchValue(newVal){
            this.search(newVal)
        }
    },
}
</script>