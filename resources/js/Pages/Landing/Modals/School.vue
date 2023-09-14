<template>
   <b-modal v-model="showModal" size="lg" hide-footer title="View School" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered>    
        <b-col md>
            <b-row class="align-items-center g-3">
                <b-col md="auto">
                    <div class="avatar-md">
                        <span v-if="school.avatar == 'school.jpg'"
                            :class="'avatar-title rounded-circle bg-primary text-white fs-24'">{{school.name[0]}}</span>
                        <img v-else :src="currentUrl+'/images/avatars/'+school.avatar" alt=""
                            class="avatar-xs">
                    </div>
                </b-col>
                <b-col md>
                    <div>
                        <h4 class="fw-bold">{{school.name}}</h4>
                        <div class="hstack gap-3 flex-wrap">
                            <div><i class="ri-building-line align-bottom me-1"></i>
                                {{ school.campus }} Campus</div>
                            <div class="vr"></div>
                            <div><i class="ri-map-pin-2-fill align-bottom me-1"></i>
                                {{ school.address }}</div>
                        </div>
                    </div>
                </b-col>
            </b-row>
            <hr/>
            
            <b-list-group class="mb-4" v-if="school.courses.length > 0">
                <b-list-group-item v-for="item in paginatedData" :key="item.id"><i class="mdi mdi-check-bold align-middle lh-1 me-2"></i>{{item.course}}</b-list-group-item>
            </b-list-group>
            <b-alert show variant="warning" class="text-center" role="alert" v-else>
            No course found.
            </b-alert>


            <nav aria-label="Page navigation example">
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
             <!-- <button @click="previousPage" :disabled="currentPage === 1">Previous</button>
    <button @click="nextPage" :disabled="currentPage === totalPages">Next</button> -->
        </b-col>
        <!-- <template v-slot:footer>
            <b-button @click="showModal = false" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary"  block>Save</b-button>
        </template> -->
    </b-modal>
</template>
<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            school: { courses: []},
            itemsPerPage: 5,
            currentPage: 1,
        }
    },
    computed: {
        totalPages() {
            return (this.school) ? Math.ceil(this.school.courses.length / this.itemsPerPage) : 'a';
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.school.courses.slice(start, end);
        },
    },
    methods: {
        show(data){
            this.school = data;
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
    }
}
</script>