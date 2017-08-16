// window.moment = require('moment');
window.moment = require('moment-timezone');

Vue.component('chat-message', require('./components/ChatMessage.vue'));
Vue.component('chat-composer', require('./components/ChatComposer.vue'));
Vue.component('chat-log', require('./components/ChatLog.vue'));

