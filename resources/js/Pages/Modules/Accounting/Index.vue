<template>

    <Head title="Financial Reports" />
    <PageHeader :title="title" :items="items" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-sidebar">
            <div class="p-4 d-flex flex-column h-100">
                 <ul class="list-group mb-4" style="cursor: pointer;">
                    <Link href="/accounting">
                        <li class="list-group-item"><i class="ri-bank-line fs-18 text-warning align-middle me-2"></i>Home</li>
                    </Link>
                    <Link href="/accounting/expenses">
                        <li class="list-group-item"><i class="ri-bank-card-line fs-18 text-warning align-middle me-2"></i>Expenses</li>
                    </Link>
                    <Link href="/accounting/allotments">
                        <li class="list-group-item"><i class="ri-funds-line fs-18 text-warning align-middle me-2"></i>Allotments</li>
                    </Link>
                    <Link href="/accounting/disbursements">
                        <li class="list-group-item"><i class="ri-hand-coin-line fs-18 text-warning align-middle me-2"></i>Disbursements</li>
                    </Link>
                    <Link href="/accounting/realignments">
                        <li class="list-group-item"><i class="ri-safe-2-line fs-18 text-warning align-middle me-2"></i>Realignments</li>
                    </Link>
                </ul>
            </div>
        </div>
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px)" ref="box">
            <slot>
                <Default :latest="latest" :old="old"/>
            </slot>
        </div>
    </div>
</template>
<script>
import Default from './Default.vue';
import PageHeader from "@/Shared/Components/PageHeader.vue";
export default {
    components: { PageHeader, Default },
    props: ['latest','old'],
    data() {
        return {
            currentUrl: window.location.origin,
            title: "Financial Reports",
            items: [{
                text: "Lists",
                href: "/",
            }, {
                text: "Financial",
                active: true,
            }],
        };
    },
}
</script>
<style>
    .file-manager-sidebar {
        min-width: 450px;
        max-width: 450px;
        height: calc(100vh - 180px);
    }

</style>
