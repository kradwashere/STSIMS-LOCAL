<template>
    <b-modal v-model="showModal" title="Switch Subject" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3 mt-2">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group mb-2 currency-value">
                                    <input type="text" class="form-control" v-model="from.code" disabled />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control text-end" v-model="to.code" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-12">
                                <input type="text" class="form-control text-center" v-model="subject" @keyup="search()" />
                        
                                <b-form-group class="mt-3 font-size-14">
                                    <b-form-radio  @change="log" v-for="list in lists" v-bind:key="list.id" v-model="selectedDefault" class="mb-1" :value="list" plain>
                                        <span class="fs-13 ms-2">{{ list.code }} {{(list.is_lab == 0) ? '(Lec)' : '(Lab)' }}</span>
                                        <span class="fs-6"> / </span>
                                        <span class="fs-13">{{ list.subject }}</span>
                                    </b-form-radio>
                                </b-form-group>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Save</b-button>
        </template>
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                errors: [],
                from: '',
                to: '',
                subject: '',
                subjects: [],
                lists: [],
                selectedDefault: '',
                scholar_id: '',
                showModal: false,
                form: {}
            }
        },

        methods: {
            set(subjects, selected, user) {
                this.from = selected;
                this.subjects = subjects;
                this.scholar_id = user;
                this.showModal = true;
            },

            create() {
                this.form = this.$inertia.form({
                    to: this.to,
                    from: this.from,
                    scholar_id: this.scholar_id,
                    type: 'switch'
                })

                this.form.put('/enrollments/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.hide();
                    }
                });
            },

            search() {
                // if (this.subject.length > 0) {
                    this.lists = this.subjects.filter(x => x.code === this.subject);
                // }
            },

            log(arg){
                this.to = arg;
            },

            hide(){
                (this.form.hasOwnProperty('reset') ) ? this.form.reset().clearErrors() : '';
                this.from = '';
                this.to = '';
                this.scholar_id = '';
                this.subject = '';
                this.subjects = [];
                this.lists = [];
                this.showModal = false;
            }
        }
    }
</script>
