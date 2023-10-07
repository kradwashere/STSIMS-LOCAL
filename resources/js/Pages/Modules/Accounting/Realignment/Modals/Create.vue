<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" style="--vz-modal-width: 700px;" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <template v-slot:header>
            <h5 class="modal-title">Request Realignment</h5>
            <button @click="hide()" type="button" class="btn-close" aria-label="Close"></button>
        </template>
        <form class="customform mt-2">
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group mb-3">
                        <label>Sender Class: <span v-if="form.errors" v-text="form.errors.sender_class" class="haveerror"></span></label>
                        <Multiselect 
                        v-model="realignment.sender" 
                        :options="senders"  
                        @search-change="sender"
                        placeholder="Type to search" 
                        track-by="id" label="name"
                        />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>Balance : <span v-if="form.errors" v-text="form.errors.name" class="haveerror"></span></label>
                        <input type="text" class="form-control test" v-money="money" v-model="realignment.sender.balance" readonly>
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <hr />
                </div>
                <div class="col-md-9">
                    <div class="form-group mb-3">
                        <label>Receiver Class: <span v-if="form.errors" v-text="form.errors.receiver_class" class="haveerror"></span></label>
                        <Multiselect 
                        v-model="realignment.receiver" 
                        :options="receivers"  
                        @search-change="receiver"
                        placeholder="Type to search" 
                        track-by="id" label="name"
                        />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>Balance : <span v-if="form.errors" v-text="form.errors.name" class="haveerror"></span></label>
                        <input type="text" class="form-control test" v-money="money" v-model="realignment.receiver.balance" readonly>
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <hr />
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label>Amount to be Transfered : <span v-if="form.errors" v-text="form.errors.name" class="haveerror"></span></label>
                        <input type="text" class="form-control test" v-money="money" v-model.lazy="realignment.amount">
                    </div>
                </div>
            </div>
        </form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="form.processing" block>Save</b-button>
        </template>
    </b-modal>
</template>
<script>
import {VMoney} from 'v-money'
import Multiselect from '@suadelabs/vue3-multiselect';
export default {
    components : { Multiselect},
    directives: {money: VMoney},
    props: ['expenditures'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: {},
            realignment: {
                sender: { balance: 0 },
                receiver: { balance: 0 },
                amount: 0
            },
            money: {
                decimal: '.',
                thousands: ',',
                prefix: '₱ ',
                precision: 2,
                masked: false
            },
            receivers: [],
            senders: [],
            showModal: false
        }
    },
    methods: {
        show(){
            this.showModal = true;
        },
        create(){
            this.form = this.$inertia.form({
                receiver_class: (this.realignment.receiver) ? this.realignment.receiver.id : '',
                sender_class: (this.realignment.sender) ? this.realignment.sender.id : '',
                amount: this.realignment.amount,
                type: 'realignment'
            })

            this.form.post('/accounting',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        receiver(value) {
            if(value.length > 3){
                axios.post(this.currentUrl + '/lists/search/expenses', {
                    word: value,
                })
                .then(response => {
                    this.receivers = response.data.data;
                })
                .catch(err => console.log(err));
            }
        },
        sender(value) {
            if(value.length > 3){
                axios.post(this.currentUrl + '/lists/search/expenses', {
                    word: value,
                })
                .then(response => {
                    this.senders = response.data.data;
                })
                .catch(err => console.log(err));
            }
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>
<style>
.multiselect__single { 
    font-size: 13px;
}
.test { 
    height: 40px;
}
</style>