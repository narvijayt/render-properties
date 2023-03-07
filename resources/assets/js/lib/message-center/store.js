import globalStore from '../global-store'

const store = {
    state: {
        active_conversation: 0,
        conversations: {
            fetched: false,
	        data: [],
            submitting_message: false,
            show_inbox: true,
        },
        scroll_bar: {},
        sidebar: {
            active: true
        }
    },

	/**
	 * Fetch all conversations from the api along with it's messages
     *
     * @returns
     */
    setConversations (conversations) {
        conversations.map(convo => {
            return transformConversation(convo)
        })

        this.state.conversations.data = conversations
    },

	/**
     * Create a new conversation
     *
	 * @param {string} title
	 * @param {int} recipientId
     * @param {string} message
     * @return Promise
	 */
	createConversation (title, recipientId, message) {
	    return window.axios.post('/api/conversations', {
                'conversation_title': title,
                'recipient': recipientId,
                'message': message
            })
            .then(response => {
                const data = response.data.data

                return data
            })
            .catch(err => {
                Flash({
                    message: 'Unable to create new conversation',
                    level: 'danger'
                })
            })
    },

    createConversationMessage (conversationId, message) {
        this.state.conversations.submitting_message = true
        return window.axios.post(`/api/conversations/${conversationId}/messages`, {
            'message_text': message
        }).then(response => {
            this.state.conversations.submitting_message = false
        })
    },

    setActiveConversation (conversation) {
        this.state.active_conversation = conversation.conversation_id
        setTimeout(() => {
            this.setSidebarActive(false)
            this.scrollBarToBottom()
        }, 300)
    },

    addMessage (conversationId, message) {
	    const conversation = this.findConversationById(conversationId)

        const messages = conversation.messages

        messages.push(message)

        conversation.updated_at = message.created_at

        setTimeout(() => {
            this.scrollBarToBottom()
        }, 300)
    },

    findConversationById(conversationId) {
	    return this.state.conversations.data.find(c => {
		    return c.conversation_id === conversationId
	    })
    },

    addConversation(conversation) {
        this.state.conversations.data.push(transformConversation(conversation))
    },

    setScrollBar (scrollBar) {
        this.state.scroll_bar = scrollBar
    },

    scrollBarToBottom () {
        if (this.state.active_conversation !== 0) {
            const scrollElement = this.state.scroll_bar.getScrollElement()
            const contentSizeY = this.state.scroll_bar.contentSizeY
            const height = this.state.scroll_bar.el.offsetHeight

            const offset = contentSizeY - height

            scrollElement.scrollTop = offset
        }
    },

    updateLastRead (conversation) {
        return window.axios.put(`/api/conversations/${conversation.conversation_id}/reads/${globalStore.state.user.user_id}`, {})
            .then(response => {
                const data = response.data.data
	            const convo = this.findConversationById(conversation.conversation_id)
                convo.self.last_read = data.last_read

                return data
            })
    },

    toggleSidebar () {
        this.state.sidebar.active = !this.state.sidebar.active
    },

    setSidebarActive (active) {
        this.state.sidebar.active = active
    },

    archiveConversation(conversation) {
        axios.put(`/api/conversations/${conversation.conversation_id}/archive`)
            .then(response => {
                const idx = this.state.conversations.data.findIndex(c => c.conversation_id === conversation.conversation_id)

                const conversations = this.state.conversations.data
                this.state.conversations.data = [
	                ...conversations.slice(0, idx),
	                transformConversation(response.data.data),
	                ...conversations.slice(idx + 1, conversations.length)
                ]
            })
    },

	unArchiveConversation(conversation) {
		axios.put(`/api/conversations/${conversation.conversation_id}/un-archive`)
			.then(response => {
				const idx = this.state.conversations.data.findIndex(c => c.conversation_id === conversation.conversation_id)

				const conversations = this.state.conversations.data
				this.state.conversations.data = [
					...conversations.slice(0, idx),
					transformConversation(response.data.data),
					...conversations.slice(idx + 1, conversations.length)
				]
			})
	}
}

export default store

/**
 * HELPERS
 */

export const transformConversation = conversation => {
	conversation.recipient = conversation.subscribers.find(sub => {
		return sub.user_id !== globalStore.state.user.user_id
	})

	conversation.self = conversation.subscribers.find(sub => {
		return sub.user_id === globalStore.state.user.user_id
	})

	return conversation
}
