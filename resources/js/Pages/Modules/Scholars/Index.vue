<template>
    <Head title="Scholars" />
    <PageHeader :title="title" :items="items" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-sidebar">
            <Sidebar :statuses="statuses" :programs="programs" @info="update()" ref="sync"/>
        </div>
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px)" ref="box">
            <List :regions="regions" :programs="programs" :dropdowns="dropdowns" :statuses="statuses" @unsync="updateSync" @info="sync" ref="lists"/>
        </div>
    </div>
</template>
<script>
import List from './List.vue';
import Sidebar from './Sidebar.vue';
import PageHeader from "@/Shared/Components/PageHeader.vue";
export default {
    props: ['statuses', 'regions', 'programs', 'dropdowns'],
    components: { PageHeader, List, Sidebar },
    data() {
        return {
            currentUrl: window.location.origin,
            title: "List of Scholars",
            items: [{text: "List",href: "/"},{text: "Scholar",active: true}],
        };
    },
    methods: {
        update(){
            this.$refs.lists.fetch();
        },
        sync(){
            this.$refs.sync.updateSync();
        },
        updateSync(data){
            this.$refs.sync.updateUnsync(data);
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
</style>
