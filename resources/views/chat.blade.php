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
<script>
window.userEmail = localStorage.getItem('useremail');
if(userEmail == null || userEmail != "{{Auth::user()->email}}"){
    localStorage.setItem('useremail', "{{Auth::user()->email}}");
}
</script>
<script src="{{mix('/js/chat.js')}}"></script>

@endsection

