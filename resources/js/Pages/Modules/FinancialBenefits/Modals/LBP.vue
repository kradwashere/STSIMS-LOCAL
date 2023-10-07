<template>
    <b-modal v-model="showModal" style="--vz-modal-width: 590px;" hide-footer header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered>
        <template v-slot:header>
            <h5 class="modal-title">Download LBP</h5>
            <button @click="showModal = false" type="button" class="btn-close" aria-label="Close"></button>
        </template>
         <button @click="saveTextAsFile('findes-lbp.txt')" class="btn btn-primary btn-sm rounded-pill btn-label float-end" type="button">
            <div class="btn-content"><i class=" ri-download-cloud-fill  label-icon align-middle rounded-pill fs-16 me-2"></i> Download Now </div>
        </button>
        <p class="text-muted">Use this txt file for importing in FinDES-PaCS</p>
        
        <div class="code-view mt-4">
            <pre class="language-markup text-dark" style="height: 200px;"><code><code ref="t" v-for="(list,index) in info.lbp" v-bind:key="index">{{list.test}}<br/></code>{{info.note}}</code></pre>
        </div>
    </b-modal>
</template>

<script>
    export default {
        data() {
            return {
                info: '',
                showModal: false
            }
        },
        methods: {
            set(data) {
                this.info = data;
                console.log(data);
                this.showModal = true;
            },
             saveTextAsFile(fileNameToSaveAs) {
                let printReceiptBody = ``;
                    this.info.lbp.forEach((x, i) => {
                        printReceiptBody += x.test+`\n`;
                    });
                printReceiptBody += this.info.note;
                let textFileAsBlob = new Blob([printReceiptBody], { type: 'text/plain' });
                let downloadLink = document.createElement('a');
                downloadLink.download = fileNameToSaveAs;
                downloadLink.innerHTML = 'Download File';

                if (window.webkitURL != null) {
                    downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
                } else {
                    downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
                    downloadLink.style.display = 'none';
                    document.body.appendChild(downloadLink);
                }

                downloadLink.click();
            }
        }
    }

</script>
