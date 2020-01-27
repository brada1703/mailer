window.Vue = require('vue');
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.config.productionTip = false;

new Vue({
    el: '#app',
    data: {
        showTab: 'subscribers',
        modal: '',
        errors: [''],
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
                    console.log("response", response)
                })
                .catch(function(error) {
                    console.log("error: ", error.response)
                    button.disabled = false
                })
                .finally(function () {
                    self.modal = ''
                })
        }
    },
});
