<template>
    <li class="messages-list__item" :class="itemClass">
        <div class="row">
            <div class="col-sm-6">
                <span class="messages-list__item-author util-block">{{ message.user_name }}</span>
            </div>
            <div class="col-sm-6">
                <span class="messages-list__item-timestamp util-block text-right">
                    {{ createdAt }}
                </span>
            </div>
        </div>
        <div class="messages-list__item-content">
            {{ message.message_text }}
        </div>
    </li>
</template>

<script>
import store from '../../lib/message-center/store'
import globalStore from '../../lib/global-store'

export default {
    props: [
        'message'
    ],
    data () {
        return {
        	global_state: globalStore.state,
            shared_state: store.state
        }
    },

    computed: {
        itemClass () {
            const user = this.global_state.user

            const selfMessage =  this.message.user_id === user.user_id

            return {
                'messages-list__item--self': selfMessage,
                'messages-list__item--recipient': !selfMessage
            }
        },
        createdAt () {
            return window.parseUTCToLocalDate(this.message.created_at).format('MMMM Do YYYY, h:mm a')
        }
    }

}
</script>

