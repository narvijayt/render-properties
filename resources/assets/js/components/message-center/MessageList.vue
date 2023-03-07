<template>
    <ul class="messages-list" id="messages-list">
        <message-list-item
            v-for="message in messages"
            :message="message"
            :key="message.message_id"
        ></message-list-item>
    </ul>
</template>

<script>
import store from '../../lib/message-center/store'
import MessageListItem from './MessageListItem.vue'

export default {
    components: {
        'message-list-item': MessageListItem
    },
    data() {
        return {
            active_conversation: store.state.active_conversation,
            conversations: store.state.conversations.data,
            shared_state: store.state
        }
    },
    computed: {
        messages () {
        	const conversation = store.findConversationById(this.shared_state.active_conversation)

            return conversation.messages
        }
    }
}
</script>

