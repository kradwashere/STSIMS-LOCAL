<template>
    <b-col lg="12">
        <b-row class="g-3">
            <b-col lg="4" v-for="(item, index) of counts" :key="index">
                <b-card no-body>
                    <b-card-body>
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                    <i :class="`${item.icon} align-middle`"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                    {{ item.name }}
                                </p>
                                <h4 class="mb-0">
                                    <span class="counter-value">
                                        {{ item.counts }}
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </b-card-body>
                </b-card>
            </b-col>
        </b-row>
    </b-col>
</template>
<script>
export default {
    props: ['school'],
    data() {
        return {
            currentUrl: window.location.origin,
            counts: []
        }
    },
    created(){
        this.fetchCount();
    },
    methods: {
        fetchCount(){
            axios.get(this.currentUrl + '/schools', {
                params: {
                    id: this.school.data.id,
                    type: 'counts'
                }
            })
            .then(response => {
                this.counts = response.data;
            })
            .catch(err => console.log(err));
        }
    }
}
</script>