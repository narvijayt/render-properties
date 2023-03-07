<template>
    <li  @click="setActive()"
         :class="{ 'conversations__tab--active': isActive }"
         class="conversations__tab">

        <div class="conversations__tab-avatar-container">
            <img class="conversations__tab-avatar" :src="conversation.recipient.avatar">
        </div>

        <div class="conversations__tab-content-container">
            <span class="conversations__tab-content-recipient util-block">
                {{ fullName }}
            </span>
            <span class="conversations__tab-content-subject util-block">{{ conversationTitle }}</span>
            <span
                v-if="unread.length > 0 && !isActive"
                class="conversations__tab-content-badge badge"
            >{{ unread.length }}</span>
        </div>
    </li>
</template>

<script>
import store from '../../lib/message-center/store'
import globalStore from '../../lib/global-store'

export default {
    props: [
        'conversation'
    ],
    data() {
        return {
            is_active: false,
            conversation_title: '',
            shared_state: store.state,
            global_state: globalStore.state,
            last_read: ''
        }
    },
    mounted() {
    	this.last_read = this.conversation.self.last_read
    },
    methods: {
        setActive() {
            store.setActiveConversation(this.conversation)
            store.updateLastRead(this.conversation)
                .then(data => {
                    this.last_read = data.last_read
                })
        }
    },
    computed: {
	    unread() {
            const last_read = this.last_read
		    return this.conversation.messages.filter(message => {
			    return message.user_id !== this.global_state.user.user_id
				    && moment(message.created_at).isSameOrAfter(moment(last_read))
		    })
	    },
        isActive() {
            return this.shared_state.active_conversation === this.conversation.conversation_id
        },
        conversationTitle() {
        	if (this.conversation.conversation_title.length > 27) {
        		return this.conversation.conversation_title.slice(0, 27) + '...'
            }

            return this.conversation.conversation_title
        },
        fullName() {
            return this.conversation.recipient.first_name + ' ' + this.conversation.recipient.last_name
        }
    },
    watch: {
    	'conversation.self.last_read': {
    		handler(newVal, oldVal) {
                this.last_read = newVal
                this.$forceUpdate()
            },
            deep: true
        }
    }
}
</script>
