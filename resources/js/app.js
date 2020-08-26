require('./bootstrap');

window.Vue = require('vue');

import poll from './components/PollComponent.vue';

const app = new Vue({
    el: '#app',
    components: {
        poll
    }
});
