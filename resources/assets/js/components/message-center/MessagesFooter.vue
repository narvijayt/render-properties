<template>
    <footer class="messages-footer">

        <form @submit.prevent="sendMessage">
            <div class="messages-footer__input-container input-group">
                <input
                    type="text"
                    v-model.trim="message"
                    :disabled="shared_state.conversations.submitting_message"
                    class="messages-footer__input form-control"
                    placeholder="Type your message here"
                >
                <span class="input-group-btn">
                    <button
                        class="btn messages-footer__submit"
                        type="submit"
                        :disabled="shared_state.conversations.submitting_message"
                    >
                        <template v-if="!shared_state.conversations.submitting_message">Send</template>
                        <template v-if="shared_state.conversations.submitting_message">
                            <i class="fa fa-spinner fa-pulse fa-fw"></i>
                            <span class="sr-only">Loading...</span>
                        </template>
                    </button>
                </span>
            </div>
        </form>

    </footer>
</template>

<script>
import store from '../../lib/message-center/store'

export default {
    data () {
        return {
            message: '',
            shared_state: store.state
        }
    },
    methods: {
        sendMessage () {
            if (this.message !== '') {
                store.createConversationMessage(this.shared_state.active_conversation, this.message)
                    .then(() => {
                        this.message = ''
                    })
            }
        }
    }
}
</script>
