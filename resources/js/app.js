window.Vue = require('vue');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.config.productionTip = false;

const vue = new Vue({
    el: '#app',
    data: {
        showTab: 'subscribers',
        modal: '',
        errors: [''],
        subscribers: [''],
        fieldValues: [''],
        fields: [''],
    },
    created: function () {
        axios.get('/fields').then(response => this.fields = response.data)
        axios.get('/api/subscribers').then(response => this.subscribers = response.data)
        axios.get('/fieldvalues').then(response => this.fieldValues = response.data)
    },
    methods: {
        show(tab) {
            this.showTab = tab
        },
        showModal(modal) {
            this.modal = modal
            let body = document.body.classList
            modal ? body.add('modal-open') : body.remove('modal-open')
        },
        closeModal(target) {
            outerModal = [document.getElementById('addSubscriber'), document.getElementById('addField')]
            outerModal.includes(target) ? this.modal = '' : ''
            let body = document.body.classList
            body.remove('modal-open')
        },
        addSubscriber(e){
            e.preventDefault()
            let button = document.querySelector('#addSubscriberButton')
            button.disabled = true
            axios
                .post(e.target.action, new FormData(e.target))
                .then(response => {
                    this.subscribers = response.data.subscribers;
                    this.fieldValues = response.data.fieldValues;
                    this.showModal('')
                })
                .catch(error => {
                    console.log("error: ", error.response)
                    button.disabled = false
                    this.errors = Object.keys(error.response.data.errors)
                })
        },
        addField(e) {
            e.preventDefault()
            let button = document.querySelector('#addFieldButton')
            button.disabled = true
            axios
                .post(e.target.action, new FormData(e.target))
                .then(response => {
                    this.fields = response.data.fields
                    this.showModal('')
                })
                .catch(error => {
                    console.log("error: ", error.response)
                    button.disabled = false
                    this.errors = Object.keys(error.response.data.errors)
                })
        }
    },
});
