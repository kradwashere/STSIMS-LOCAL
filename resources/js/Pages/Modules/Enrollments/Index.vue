<template>
    <Head title="Qualifiers" />
    <PageHeader :title="title" :items="items" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-sidebar">
            <Sidebar />
        </div>
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px)" ref="box">
            <Assessment v-if="show == 'assessment'" :lists="lists" :selected="selected" :gradings="scholar.education.school.gradings" :user="scholar.code" @status="message" ref="assessment"/>
            <Prospectus v-else-if="show == 'prospectus'" ref="prospectus"/>
            <Enrollment v-else-if="show == 'enroll'" :user="scholar" :dropdowns="dropdowns" ref="enroll"/>
        </div>
    </div>
</template>
<script>
import Sidebar from './Sidebar.vue';
import Assessment from './Pages/Assessment.vue';
import Enrollment from './Pages/Enrollment.vue';
import Prospectus from './Pages/Prospectus.vue';
import PageHeader from "@/Shared/Components/PageHeader.vue";
export default {
    components: { PageHeader, Sidebar, Prospectus , Enrollment, Assessment},
    props: ['dropdowns'],
    data() {
        return {
            currentUrl: window.location.origin,
            title: "List of Enrollments",
            items: [{text: "List",href: "/"},{text: "Enrollment",active: true}],
            show: 'default',
            lists: null,
            selected: null
        };
    },
    methods: {
        prospectus(type,data){
            this.show = type; 
            this.$nextTick(function () {
                this.$refs.prospectus.set(data)
            });
        },
        enroll(type,scholar){
            this.show = type; 
            this.scholar = scholar;
            this.$nextTick(function () {
                this.$refs.enroll.fetchSemesters(this.scholar.education.school.id, this.scholar.awarded_year,this.scholar.education.school.semester);
            });
        },
        assessment(type,list,scholar){
            this.show = type; 
            this.selected = list;
            this.scholar = scholar;
            axios.get(this.currentUrl + '/enrollments/' + list.id)
            .then(response => {
                this.lists = response.data.data;
                this.$nextTick(function () {
                    this.$refs.assessment.set(this.lists);
                });
            })
            .catch(err => console.log(err));
        },
        message(list) {
            let index = '';
            switch(this.show){
                case 'course': 
                    this.scholar = list;
                    this.viewProspectus();
                break;
                case 'create':
                    index = this.scholar.enrollments.findIndex(u => u.id === list.id);
                    if (index >= 0) {
                        this.scholar.enrollments[index] = list;
                        this.check();
                    }else{
                        this.scholar.enrollments.unshift(list);
                        this.check();
                        this.fetchLists(list);
                        this.scholar.education.school.is_enrolled = true;
                    }
                break;
                default:
                    this.selected = list;
                    index = this.scholar.enrollments.findIndex(u => u.id === list.id);
                    this.scholar.enrollments[index] = list;
            }
        },
    }
}
</script>
<style>
    .file-manager-sidebar {
        min-width: 450px;
        max-width: 450px;
        height: calc(100vh - 180px);
    }
</style>
