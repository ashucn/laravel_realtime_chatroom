@extends('layouts.chat')

@section('styles')
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
@section('content')

<div id="app">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading"><h1>Chat Room</h1></div>

            <div class="panel-body">

                <chat-log :messages="messages"></chat-log>
                <chat-composer @messagesent="addMessage"></chat-composer>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{mix('/js/chat.js')}}"></script>
<script>

let userEmail = localStorage.getItem('useremail');
const app = new Vue({
    el: '#app',
    data: {
        messages: []
    },
    methods: {
        addMessage(message){
            message.user = { email: "{{Auth::user()->email}}" };
            // post a message to db
            axios.post('/messages', message).then(response => {
                message.created_at = response.data.created_at;
                if(userEmail == message.user.email){
                    this.messages.push(message);
                }
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
                if(userEmail != msg.user.email){
                    this.messages.push(msg);
                }

                $("html, body").animate({ scrollTop: $(document).height() }, "fast");

            });

        // get all messages from db
        axios.get('/messages').then(response => {
            this.messages = response.data;
        });
        var userEmail = localStorage.getItem('useremail');
        if(userEmail == null || userEmail != "{{Auth::user()->email}}"){
            localStorage.setItem('useremail', "{{Auth::user()->email}}");
        }

    }
});

toastr.options = {
  "positionClass": "toast-top-center"
}

$(document).ready(function(){
    $("html, body").animate({ scrollTop: $(document).height() }, "fast");
});

</script>

@endsection

