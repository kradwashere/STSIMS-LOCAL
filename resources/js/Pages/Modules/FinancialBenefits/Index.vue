<template>
    <Head title="Qualifiers" />
    <PageHeader :title="title" :items="items" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-sidebar">
            <div class="p-4 d-flex flex-column h-100">
                <Sidebar :privileges="privileges" latest="latest" @info="release" @update="fetch" ref="sidebar"/>
            </div>
        </div>
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px)" ref="box">
            <List v-if="show == 'default'"/>
            <Generate latest="latest" v-else-if="show == 'generate'" ref="generate" @status="show = 'default'"/>
        </div>
    </div>
</template>
<script>
import List from './Pages/List.vue';
import Generate from './Pages/Generate.vue';
import Sidebar from './Sidebar.vue';
import PageHeader from "@/Shared/Components/PageHeader.vue";
export default {
    props: ['privileges'],
    components: { PageHeader, Sidebar, List, Generate },
    data() {
        return {
            currentUrl: window.location.origin,
            title: "Financial Benefits",
            items: [{text: "List",href: "/"},{text: "Benefits",active: true}],
            show: 'default',
            latest: { pending: [], scholars: [] },
        };
    },
    created(){
        this.fetch();
    },
    methods: {
        fetch() {
            axios.get(this.currentUrl + '/financial-benefits/create', {
                params: { type: 'generate' }
            })
            .then(response => {
                this.latest = response.data;
                this.$refs.sidebar.set(this.latest);
            })
            .catch(err => console.log(err));
        },
        release(){
            this.show = 'generate';
            this.$nextTick(function () {
                this.$refs.generate.fetch(this.latest);
            });
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
