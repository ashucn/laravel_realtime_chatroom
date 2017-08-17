// window.moment = require('moment');
window.moment = require('moment-timezone');

Vue.component('chat-message', require('./components/ChatMessage.vue'));
Vue.component('chat-composer', require('./components/ChatComposer.vue'));
Vue.component('chat-log', require('./components/ChatLog.vue'));

const app = new Vue({
    el: '#app',
    data: {
        messages: [],
        usersInRoom: []
    },
    methods: {
        addMessage(message){
            // post a message to db
            axios.post('/messages', message).then(response => {
                message.user = {email : userEmail};
                message.created_at = response.data.created_at;
                console.log(this.usersInRoom);
                $("html, body").animate({ scrollTop: $(document).height() }, "fast");
            });
        }
    },
    created: function(){
        console.log("test echo");
        // Echo.private(‘ashuchatroom’);
        Echo.join('ashuchatroom')
            .here((users) => {
                this.usersInRoom = users;
            })
            .joining((user)=>{
                this.usersInRoom.push(user);
            })
            .leaving((user)=>{
                this.usersInRoom = this.usersInRoom.filter( u => u != user );
            })
            .listen('MessagePosted', (event) => {
                console.log(event);
                // handle event
                let msg = {
                    message: event.message.message,
                    user: {
                        email: event.user.email
                    }
                }
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
