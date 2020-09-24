<template>
    <div class="container">
        <div class="row d-flex pt-4 justify-content-center">
            <div class="col-md-7 rounded p-4 col-md-offset-2 bg-white">
                <div class="panel panel-default">
                    <div id="panel-heading">Chats</div>

                    <div id="panel-body">
                        <chat-messages :messages="messages"></chat-messages>
                    </div>
                    <div class="panel-footer">
                        <chat-form v-on:messagesent="addMessage" :user=user></chat-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import ChatMessages from '../components/ChatMessages.vue'
    import ChatForm from '../components/ChatForm.vue'
    import $axios from '../api.js'
    import {
        mapActions,
        mapState
    } from 'vuex'
    export default {
        data() {
            return {
                messages: []
            }
        },

        created() {
            this.fetchMessages();
            window.Echo.private('chat')
                .listen('MessageSent', (e) => {
                    this.messages.push({
                        message: e.message.message,
                        created_at: moment(e.message.created_at).fromNow(),
                        user: e.user
                    });
                });
        },

        computed: {
            ...mapState('user', {
                user: state => state.authenticated
            })
        },

        methods: {
            ...mapActions('user', ['getUserLogin']),
            fetchMessages() {
                $axios.get('/messages').then(response => {
                    this.messages = response.data;
                    this.scrollToBottom()
                });
            },


            addMessage(message) {
                // this.messages.push(message);

                $axios.post('/messages', message).then(response => {
                    console.log(response.data);
                    this.scrollToBottom()
                });
            },

            scrollToBottom() {
                setTimeout(function () {
                    let chatLists = document.getElementById('panel-body')
                    chatLists.scrollTop = chatLists.scrollHeight
                }, 1)
            }
        },

        components: {
            'chat-messages': ChatMessages,
            'chat-form': ChatForm,
        }
    }
</script>

<style>
    .chat {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .chat li {
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px dotted #B3A9A9;
    }

    .chat li .chat-body p {
        margin: 0;
        color: #777777;
    }

    #panel-heading {
        font-size: 2rem;
        font-weight: 600;

        letter-spacing: .025em;
        text-transform: uppercase;
    }

    #panel-body {
        overflow-y: scroll;
        height: 350px;
    }

    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #F5F5F5;
    }

    ::-webkit-scrollbar {
        width: 12px;
        background-color: #F5F5F5;
    }

    ::-webkit-scrollbar-thumb {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        background-color: #555;
    }
</style>