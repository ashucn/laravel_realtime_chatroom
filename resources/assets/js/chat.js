// window.moment = require('moment');
window.moment = require('moment-timezone');

Vue.component('chat-message', require('./components/ChatMessage.vue'));
Vue.component('chat-composer', require('./components/ChatComposer.vue'));
Vue.component('chat-log', require('./components/ChatLog.vue'));


const app = new Vue({
    el: '#app',
    data: {
        messages: []
    },
    methods: {
        addMessage(message){
            // post a message to db
            axios.post('/messages', message).then(response => {
                message.created_at = response.data.created_at;
                this.messages.push(message);
                $("html, body").animate({ scrollTop: $(document).height() }, "fast");
            });
        }
    },
    created: function(){
        console.log("test echo");
        // Echo.private(‘ashuchatroom’);
        Echo.private('ashuchatroom')
            .listen('MessagePosted', (event) => {
                console.log(event);
                // handle event
                let msg = {
                    message: event.message.message,
                    user: {
                        email: event.user.email
                    }
                }

                console.log(userEmail, msg.user.email);
                    this.messages.push(msg);

                $("html, body").animate({ scrollTop: $(document).height() }, "fast");

            });

        // get all messages from db
        axios.get('/messages').then(response => {
            this.messages = response.data;
        });

    }
});

toastr.options = {
  "positionClass": "toast-top-center"
}

$(document).ready(function(){
    $("html, body").animate({ scrollTop: $(document).height() }, "fast");
});
