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
        axios.get('/api/fields').then(response => this.fields = response.data)
        axios.get('/api/subscribers').then(response => this.subscribers = response.data)
        axios.get('/api/fieldvalues').then(response => this.fieldValues = response.data)
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
        addSubscriber(e) {
            e.preventDefault()
            let button = document.querySelector('#addSubscriberButton')
            button.disabled = true
            axios
                .post(e.target.action, new FormData(e.target))
                .then(response => {
                    this.subscribers = response.data.subscribers;
                    this.fieldValues = response.data.fieldValues;
                    this.showModal('')
                    document.getElementById('subscriberForm').reset()
                })
                .catch(error => {
                    console.log("error: ", error.response)
                    this.errors = Object.keys(error.response.data.errors)
                })
                .finally(function () {
                    button.disabled = false
                })
        },
        deleteSubscriber(e) {
            e.preventDefault()
            let id = new FormData(e.target).get('subscriber_id')
            let user = new FormData(e.target).get('subscriber_email')
            let button = document.querySelector('#deleteSubscriber' + id)
            button.disabled = true
            if (confirm('Are you sure you want to delete ' + user + '?')) {
                axios
                    .post(e.target.action, new FormData(e.target))
                    .then(response => {
                        this.subscribers = response.data.subscribers;
                        this.fieldValues = response.data.fieldValues;
                    })
                    .catch(error => {
                        console.log("error: ", error.response)
                        this.errors = Object.keys(error.response.data.errors)
                    })
                    .finally(function () {
                        button.disabled = false
                    })
            }
        },
        editSubscriber(e) {
            e.preventDefault()
            let button = document.querySelector('#editSubscriberButton')
            button.disabled = true
            console.log(e)
            // axios
            //     .post(e.target.action, new FormData(e.target))
            //     .then(response => {
            //         this.subscribers = response.data.subscribers;
            //         this.fieldValues = response.data.fieldValues;
            //         this.showModal('')
            //     })
            //     .catch(error => {
            //         console.log("error: ", error.response)
            //         button.disabled = false
            //         this.errors = Object.keys(error.response.data.errors)
            //     })
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
                    document.getElementById('fieldForm').reset()
                })
                .catch(error => {
                    console.log("error: ", error.response)
                    button.disabled = false
                    this.errors = Object.keys(error.response.data.errors)
                })
                .finally(function () {
                    button.disabled = false
                })
        },
        deleteField(e) {
            e.preventDefault()
            let id = new FormData(e.target).get('field_id')
            let title = new FormData(e.target).get('field_title')
            let button = document.querySelector('#deleteField' + id)
            button.disabled = true
            if (confirm('Are you sure you want to delete ' + title + '?')) {
                axios
                    .post(e.target.action, new FormData(e.target))
                    .then(response => {
                        this.fields = response.data.fields;
                    })
                    .catch(error => {
                        console.log("error: ", error.response)
                        this.errors = Object.keys(error.response.data.errors)
                    })
            }
            button.disabled = false
        },
    },
});
