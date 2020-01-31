window.Vue = require('vue');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.config.productionTip = false;

const vue = new Vue({
    el: '#app',
    data: {
        showTab: 'subscribers',
        modal: '',
        errors: [],
        subscribers: [],
        fieldValues: [],
        fields: [],
        editableSubscriber: [],
        editableFieldValues: [],
        editableField: [],
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
            // Refactor this
            outerModal = [
                document.getElementById('addSubscriber'),
                document.getElementById('editSubscriber'),
                document.getElementById('addField'),
                document.getElementById('editField')
            ]
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
        loadSubscriber(id) {
            axios.get('/api/subscribers/' + id).then(response => {
                this.editableSubscriber = response.data.subscriber[0];
                this.editableFieldValues = response.data.values;
            })
        },
        editSubscriber(e) {
            e.preventDefault()
            let id = new FormData(e.target).get('editableSubscriberId')
            let button = document.querySelector('#editSubscriberButton' + id)
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
                    this.errors = Object.keys(error.response.data.errors)
                })
            button.disabled = false
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
        loadField(id) {
            axios.get('/api/fields/' + id).then(response => { this.editableField = response.data.field[0] })
        },
        editField(e) {
            e.preventDefault()
            let id = new FormData(e.target).get('editableFieldId')
            let button = document.querySelector('#editFieldButton' + id)
            button.disabled = true
            axios
                .post(e.target.action, new FormData(e.target))
                .then(response => {
                    this.fields = response.data.fields;
                    this.fieldValues = response.data.fieldValues;
                    this.showModal('')
                })
                .catch(error => {
                    console.log("error: ", error.response)
                    this.errors = Object.keys(error.response.data.errors)
                })
            button.disabled = false
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
