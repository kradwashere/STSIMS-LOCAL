<template>

    <Head title="Dashboard" />
    <PageHeader :title="title" :items="items" />

</template>
<script>
    import PageHeader from "@/Shared/Components/PageHeader.vue";
    export default {
        components: {
            PageHeader
        },
        page: {
            title: "Dashboard",
            meta: [{
                name: "description"
            }],
        },
        data() {
            return {
                title: "Dashboard",
                items: [{
                        text: "View",
                        href: "/",
                    },
                    {
                        text: "Dasboard",
                        active: true,
                    },
                ],
            };
        },
    }

</script>
