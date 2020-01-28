window.Vue = require('vue');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.config.productionTip = false;

new Vue({
    el: '#app',
    data: {
        showTab: 'subscribers',
        modal: '',
        errors: [''],
        subscribers: [''],
        fieldValues: [''],
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
            outerModal = document.getElementById('addSubscriber')
            target == outerModal ? this.modal = '' : ''
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
        }
    },
});
