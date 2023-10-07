<template>
    <b-modal v-model="showModal" title="Confirm Enrollment" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>    
        <div class="modal-body">
            <div class="mt-0" v-if="Object.keys(errors).length === 0">
                <p class="text-muted mb-2"><code>Are you sure you want to submit enrollment?</code></p>
            </div>
             <div class="mt-0" v-else>
                <p class="text-muted mb-2">Please check the following fields.</p>
            </div>
            <div class="live-preview">
                <ul class="list-group">
                    <li class="list-group-item text-danger" v-for="(error,index) in errors" v-bind:key="index"><i class="mdi mdi-check-bold align-middle lh-1 me-2"></i> 
                        {{ error }} 
                    </li>
                </ul>
            </div>
            <hr v-if="errors.length == 0" class="text-muted"/>
            <p v-if="errors.length == 0" class="text-muted mb-2">Please attach certificate of registration. (Required)</p>
            <input v-if="errors.length == 0" multiple type="file" @change="uploadFieldChange" class="form-control mb-n2" :class="[($page.props.errors['files.'+0]) ? 'text-danger' : '']" style="width: 100%; height: auto;"/>
        </div>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Save</b-button>
        </template>
    </b-modal>
</template>
<script>
export default {
    props: ['user'],
    data() {
        return {
            currentUrl: window.location.origin,
            errors: [],
            value: '',
            enrollments: [],
            class_type: '',
            showModal: false,
            form: {},
            attachments: [],
        }
    },

    created() {
        this.enrollments = this.user.enrollments;
        this.class_type = this.user.education.school.class;
    },

    methods: {
        set(value) {
            this.value = value;
            this.showModal = true;
        },
        uploadFieldChange(e) {
            e.preventDefault();
            var files = e.target.files || e.dataTransfer.files;

            if (!files.length)
                return;
            for (var i = files.length - 1; i >= 0; i--) {
                this.attachments.push(files[i]);
            }
        },
        create() {
            if(this.attachments.length > 0){
                for (var i = this.attachments.length - 1; i >= 0; i--) {
                    this.value.append('files[]', this.attachments[i]);
                }
            }else{
                this.value.append('files[]', []);
            }
            this.$inertia.post('/enrollments', this.value, {
                preserveScroll: true,
                forceFormData: true,
                onSuccess: (response) => {
                    this.showModal = false;
                },
                onError: () => {
                    this.errors = this.$page.props.errors;
                }
            });
        },
        hide() {
            this.showModal = false;
            this.errors = [];
        }
    }
}
</script>
