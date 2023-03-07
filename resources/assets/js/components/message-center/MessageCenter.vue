<template>
    <div>
        <button
            type="button"
            id="message-center__toggle-button"
            class="message-center__toggle-button"
            @click="toggleSidebar"
        >
            <span v-if="!shared_state.sidebar.active">&lt; Back To Conversations</span>
            <span v-if="shared_state.sidebar.active">Back to Messages &gt;</span>
        </button>
        <section class="message-center">
            <aside class="message-center__sidebar" :class="{'message-center__sidebar--active': shared_state.sidebar.active}">
                <div class="message-center__sidebar-wrapper" id="conversations_sidebar">
                    <conversations></conversations>
                </div>
            </aside>
            <section class="message-center__conversation messages">
                <template v-if="shared_state.active_conversation > 0">
                    <messages-header></messages-header>
                    <messages-body></messages-body>
                    <messages-footer></messages-footer>
                </template>
                <template v-else>
                    <div class="message-center__no-conversation-selected">
                        <strong>Select a conversation</strong>
                    </div>
                </template>
            </section>
        </section>
    </div>
</template>

<script>
    import store from '../../lib/message-center/store'
    import globalStore from '../../lib/global-store'
    import Conversations from './Conversations.vue'
    import MessagesHeader from './MessagesHeader.vue'
    import MessagesBody from './MessagesBody.vue'
    import MessagesFooter from './MessagesFooter.vue'

    export default {
        components: {
            'conversations': Conversations,
            'messages-header': MessagesHeader,
            'messages-body': MessagesBody,
            'messages-footer': MessagesFooter
        },
        props: [
            'conversations'
        ],
        data() {
        	return {
        		global_state: globalStore.state,
                shared_state: store.state
            }
        },

        mounted() {
        	store.setConversations(this.conversations.data)
//
            EventBus.$on('message-center.new-message', message => {
            	store.addMessage(message.conversation_id, message)
                if (this.shared_state.active_conversation === message.conversation_id) {

            		store.updateLastRead(store.findConversationById(message.conversation_id))
                }
            })

            EventBus.$on('message-center.new-conversation', conversation => {
                store.addConversation(conversation)
            })
        },

        methods: {
            setActiveConversation(conversation) {
                store.setActiveConversation(conversation)
            },
            toggleSidebar () {
                store.toggleSidebar()
            }
        },
    }
</script>
