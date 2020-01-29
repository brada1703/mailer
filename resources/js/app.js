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
        axios.get('/subscribers').then(response => this.subscribers = response.data)
        axios.get('/fieldvalues').then(response => this.fieldValues = response.data)
    },
    methods: {
        filteredValues(subscriber_id, field_id) {
            let value = vue.fieldValues.filter(fieldValue => fieldValue.subscriber_id == subscriber_id && fieldValue.field_id == field_id).length
            return value ? vue.fieldValues.filter(fieldValue => fieldValue.subscriber_id == subscriber_id && fieldValue.field_id == field_id) : ''


            // console.log(value)
            // if (value) {
                // return vue.fieldValues.filter(fieldValue => fieldValue.subscriber_id == subscriber_id && fieldValue.field_id == field_id)
            // }
            // return value ? vue.fieldValues.filter(fieldValue => fieldValue.subscriber_id == subscriber_id && fieldValue.field_id == field_id) : ''
        },
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
            let self = this
            let action = e.target.action
            let formData = new FormData(e.target)
            let button = document.querySelector('#addSubscriberButton')
            button.disabled = true
            axios
                .post(action, formData)
                .then(function(response){
                    self.subscribers = response.data.subscribers
                    self.fieldValues = response.data.fieldValues
                    self.showModal('')
                })
                .catch(function(error) {
                    console.log("error: ", error.response)
                    button.disabled = false
                    self.errors = Object.keys(error.response.data.errors)
                })
        },
        addField(e) {
            e.preventDefault()
            let self = this
            let action = e.target.action
            let formData = new FormData(e.target)
            let button = document.querySelector('#addFieldButton')
            button.disabled = true
            axios
                .post(action, formData)
                .then(function(response){
                    self.fields = response.data.fields
                    self.showModal('')
                })
                .catch(function(error) {
                    console.log("error: ", error.response)
                    button.disabled = false
                    self.errors = Object.keys(error.response.data.errors)
                })
        }
    },
});
