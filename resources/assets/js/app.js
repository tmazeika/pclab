require('./bootstrap');

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#vue'
});
