<template>
    <b-modal v-model="showModal" title="Custom Subject" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <b-form class="customform mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3 mt-2">
                        <div class="row mt-2">
                            <div class="col-sm-12">
                                <input type="text" class="form-control text-center" placeholder="Search Subject" v-model="subject" @keyup="search()" />

                                <b-form-group class="mt-3 font-size-14">
                                    <b-form-radio  @change="log" v-for="list in lists" v-bind:key="list.id" v-model="selectedDefault" class="mb-1" :value="list" plain>
                                        <span class="font-size-13">{{ list.code }} {{(list.is_lab == 0) ? '(Lec)' : '(Lab)' }}</span>
                                        <span class="font-size-6"> / </span>
                                        <span class="font-size-13">{{ list.subject }}</span>
                                    </b-form-radio>
                                </b-form-group>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="showModal = false" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary"  block>Save</b-button>
        </template>
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                currentUrl: window.location.origin,
                errors: [],
                subject: '',
                subjects: [],
                lists: [],
                selected: [],
                selectedDefault: '',
                showModal: false
            }
        },

        methods: {
            create() {
                this.$emit('add', this.selectedDefault);
                this.showModal = false;
                let index = this.subjects.findIndex(x => x.code === this.selectedDefault.code);
                this.subjects.splice(index,1);
                this.selectedDefault = '';
                this.lists = [];
                this.subject = '';
            },

            set(subjects) {
                subjects.forEach((subject) => {
                    if(!subject.hasOwnProperty("is_failed")){
                        this.subjects.push(subject);     
                    }else{
                        if(subject.is_failed){
                            this.subjects.push(subject);
                        }
                    }
                });
                this.showModal = true;
            },

            search() {
                if (this.subjects.length > 0) {
                    this.lists = this.subjects.filter(x => x.code === this.subject);
                }
            },

            log(arg){
                this.to = arg;
            },

            show(){
                this.showModal = true;
            }
        }
    }
</script>
