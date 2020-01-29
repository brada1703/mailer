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
        axios
            .get('/subscribers')
            .then(function (response) {
                vue.subscribers = response.data
            })
            .catch(function(error) {
                console.log("error: ", error.response)
            })

        // axios
        //     .get('/fields')
        //     .then(function (response) {
        //         vue.fields = response.data.data
        //     })
        //     .catch(function(error) {
        //         console.log("error: ", error.response)
        //     })

        // axios
        //     .get('/fieldvalues')
        //     .then(function (response) {
        //         vue.fields = response.data.data
        //     })
        //     .catch(function(error) {
        //         console.log("error: ", error.response)
        //     })
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
