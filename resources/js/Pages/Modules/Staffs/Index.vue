<template>
<Head title="Staffs" />
<PageHeader :title="title" :items="items" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-sidebar">
            <History />
        </div>
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px)">
            <Lists />
        </div>
    </div>
</template>
<script>
import History from './History.vue';
import Lists from './Lists.vue';
import PageHeader from "@/Shared/Components/PageHeader.vue";
export default {
    components : { PageHeader, Lists, History },
    data() {
        return {
            title: "List of Staffs",
            items: [{text: "Lists",href: "/",},{text: "Staff",active: true,},]
        };
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
