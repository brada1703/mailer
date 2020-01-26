window.Vue = require('vue');
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.config.productionTip = false;

const app = new Vue({
    el: '#app',
    data: {
        showTab: 'subscribers',
    },
    methods: {
        show(tab) {
          this.showTab = tab
        },
    },
});
