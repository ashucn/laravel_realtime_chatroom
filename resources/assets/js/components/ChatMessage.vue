<template>
    <tr>
        <td v-bind:class="{'text-right': owner}">
            <h3>{{message.message}}</h3>
            <small v-if="!owner">{{message.user.email}}</small>
            <small v-if="owner" v-bind:class="{'text-danger': owner}">Me</small>
            <small> {{createat}}</small>
        </td>
    </tr>
</template>

<script>
export default {
    props: ['message'],
    data: function (){
        return {
            owner: false,
            createat: ''
        }
    },
    created: function(){
        //
        this.createat = moment.tz(this.message.created_at, "America/Los_Angeles").toNow();
        if(userEmail == this.message.user.email){
            this.owner = true;
        }
    }
}
</script>
<style lang="css">

</style>
