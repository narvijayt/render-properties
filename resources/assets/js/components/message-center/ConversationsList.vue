<template>
    <div class="conversations_sidebar__body" ref="conversationList">
        <ul class="conversations">
            <conversation-tab
                    v-for="convo in conversations"
                    :conversation="convo"
                    :key="convo.id">
            </conversation-tab>
        </ul>
    </div>
</template>

<script>
	import ConversationTab from './ConversationTab.vue'
	import SimpleBar from 'simplebar'

	export default {
		components: {
			'conversation-tab': ConversationTab
		},
		props: [
			'conversations'
		],
		data() {
			return {}
		},
		mounted () {
			// console.log(this.$refs.conversationList)
			new SimpleBar(this.$el)
		},
	}
</script>
