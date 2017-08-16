<template>
    <table class="table table-striped">
        <tbody>
            <chat-message v-for="message in messages" :message="message" :key="message.id" @messagesend=""></chat-message>
        </tbody>
        <div class="empty" v-if="messages.length === 0">Empty</div>
    </table>
</template>

<script>
export default {
    props:['messages']
}

</script>
<style lang="css">

</style>
