<template>
  <section class="messages-body">
        <message-list></message-list>
    </section>
</template>

<script>
import store from '../../lib/message-center/store'
import MessageList from './MessageList.vue'
import SimpleBar from 'simplebar'

export default {
    components: {
        'message-list': MessageList
    },
    props: [
        'messages'
    ],
    mounted () {
        store.setScrollBar(new SimpleBar(this.$el))
    },
    data() {
        return {
            shared_state: store.state
        }
    }
}
</script>
