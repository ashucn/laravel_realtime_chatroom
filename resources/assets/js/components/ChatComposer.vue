<template>
    <div class="chat-composer messages">
        <input type="text" name="" v-model="messageText" @keyup.enter="sendMessage" class="form-control">
        <button class="btn btn-primary" @click="sendMessage" :disabled="messageText==''">Send</button>
    </div>
</template>

<script>
export default {
    data(){
        return {
            messageText: ''
        }
    },
    methods:{
        sendMessage(){
            if(this.messageText == ''){
                toastr.warning('Please enter message.')
                return;
            }
            this.$emit('messagesent', {
                message: this.messageText,
            });
            this.messageText = ''
        }
    },
    mounted() {
    }
}
</script>
<style lang="css">
    .chat-composer {
        display: flex;
    }
    .chat-composer input {
        flex: 1 auto;
    }
</style>
