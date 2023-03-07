<template>
    <div class="conversations_sidebar">
        <div class="conversations_sidebar__header">
            <div class="btn-group btn-group-justified conversations_sidebar__inbox-btns" role="group" aria-label="...">
                <div class="btn-group">
                    <button
                            type="button"
                            class="btn btn-default btn-switch"
                            :class="{'active': shared_state.conversations.show_inbox}"
                            @click="showInbox()"
                    ><i class="fa fa-fw fa-inbox"></i> Inbox
                    </button>
                </div>
                <div class="btn-group">
                    <button
                            type="button"
                            class="btn btn-default btn-switch"
                            :class="{'active': !shared_state.conversations.show_inbox}"
                            @click="showArchived()"
                    ><i class="fa fa-fw fa-archive"></i> Archived
                    </button>
                </div>
            </div>

        </div>
        <conversations-list :conversations="conversations"></conversations-list>
    </div>

</template>

<style lang="sass">
    .conversations_sidebar
        display: flex
        flex-direction: column
        height: 100%
        &__header
            flex: 0 0 30px
            border-bottom: 1px solid #eeeeee
        &__body
            flex: 1
        &__inbox-btns
    /*margin-bottom: 5px*/
</style>

<script>
	import store from '../../lib/message-center/store'
	import ConversationsList from './ConversationsList.vue'
	import SimpleBar from 'simplebar'

	export default {
		components: {
			'conversations-list': ConversationsList,
		},
		data() {
			return {
				shared_state: store.state,
			}
		},
		mounted() {
			// console.log(this.$refs.conversationList)
			// console.log(SimpleBar)
			// const bar = new SimpleBar(this.$refs.conversationList)
			// console.log(bar)
		},
		methods: {
			showInbox() {
				this.shared_state.conversations.show_inbox = true
			},

			showArchived() {
				this.shared_state.conversations.show_inbox = false
			},
		},
		computed: {
			conversations() {
				console.log('re-computing conversations',)
				const conversations = [...this.shared_state.conversations.data]
					.filter(convo => {
						if (this.shared_state.conversations.show_inbox !== true) {
							return convo.self.archived !== null;
						}

						return convo.self.archived === null;
					})

				conversations.sort((a, b) => {
					return moment(b.updated_at).diff(a.updated_at)
				})

				return conversations
			},
		},
	}
</script>
