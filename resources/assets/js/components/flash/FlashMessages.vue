<template>
    <aside class="alert__container">
        <template v-for="message in flash_messages">
            <flash-message :message="message" @deleteMessage="deleteMessage(message.id)"></flash-message>
        </template>
    </aside>
</template>

<script>
import FlashMessage from './FlashMessage.vue'

export default {
	props: ['messages'],
    components: {
	    'flash-message': FlashMessage
    },
    data () {
		return {
			flash_messages: [],
            counter: 1
        }
    },
    created () {
	    this.flash_messages = this.messages.map(message => {
	    	message.id = this.counter++

            return message
        })
        window.EventBus.$on('flash', message => {
        	message.id = this.counter++

        	this.flash_messages.push(message)
        })
    },
    methods: {
		deleteMessage (id) {
            const index = this.flash_messages
                .map(message => message.id)
                .indexOf(id)
            this.flash_messages.splice(index, 1)
		}
    }
}
</script>