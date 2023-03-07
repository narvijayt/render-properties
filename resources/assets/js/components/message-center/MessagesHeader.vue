<template>
    <header class="messages-header">
        <div class="messages-header__avatar-container">
            <img class="messages-header__avatar" :src="conversation.recipient.avatar" />
        </div>
        <div class="pull-right">
            <button class="btn btn-warning btn-sm" @click="toggleArchive()">
                <i class="fa fa-fw" :class="{
            	    'fa-trash': !archived,
            	    'fa-undo': archived
                }"></i>
                Archive Conversation
            </button>
        </div>
        <div class="messages-header__content">
            <h3 class="messages-header__recipient">
                {{ conversation.recipient.first_name }} {{ conversation.recipient.last_name }}
            </h3>
            <a :href="profileLink" class="messages-header__profile-link">View Profile</a>

            <span class="messages-header__subject"><strong>Subject:</strong> {{ conversation.conversation_title }}</span>


        </div>
    </header>
</template>

<script>
    import store from '../../lib/message-center/store'

    export default {
        data() {
        	return {
		        shared_state: store.state
            }
        },
        methods: {
        	toggleArchive() {
        		if (this.conversation.self.archived === null) {
			        store.archiveConversation(this.conversation)
                }

		        store.unArchiveConversation(this.conversation)
            }
        },
        computed: {
        	conversation() {
        		return store.findConversationById(this.shared_state.active_conversation)
            },
            profileLink () {
                return `/user/ritu`
            },
            archived () {
        		return this.conversation.self.archived !== null
            }
        }
    }
</script>
