<template>
    <div>
        <button type="button" class="btn btn-warning btn-block util__mb--small" @click="show()">Send A Message</button>
        <div v-show="visible">
            <div

                    class="modal fade send-message__model"
                    :class="{
                        'in': modalVisible,
                    }"
                    role="dialog"
                    tabindex="-1"
                    @click.self="close()"
                    aria-labelledby="myModalLabel"
            >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" aria-label="Close" @click="close()">
                            <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">
                                Start a new conversation with {{ recipient.first_name }} {{ recipient.last_name }}
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="convoSubject">Subject</label>
                                <input type="text" class="form-control" id="convoSubject" placeholder="Subject" v-model="subject">
                            </div>
                            <div class="form-group">
                                <label for="convoMessage">Message</label>
                                <textarea class="form-control" id="convoMessage" placeholder="Message" v-model="message"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" @click="close()">Close</button>
                            <button type="button" class="btn btn-primary" :disabled="submitting" @click="sendMessage()">
                            <template v-if="sendBtn">Send Message</template>
                        <template v-if="loading">
                            <i class="fa fa-spinner fa-pulse fa-fw"></i>
                            <span class="sr-only">Loading...</span>
                        </template>
                            
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .send-message__model {
        display: block;
        padding-left: 0px;
    }
</style>

<script>
	import store from '../../lib/message-center/store'

	export default {
		props: [
			'recipient'
		],
		data() {
			return {
				subject: '',
                message: '',
				visible: false,
                modalVisible: false,
				shared_state: store.state,
                submitting: false,
                sendBtn: true,
                loading:false,
                
			}
		},
		methods: {
			sendMessage () {
			    this.submitting = true
			    this.sendBtn = false
			    this.loading = true
				store.createConversation(this.subject, this.recipient.user_id, this.message)
                    .then(data => {
                    this.submitting = false
                    this.loading = false
                    this.sendBtn = true
                        this.close()
                        Flash({
                            'message': 'Message successfully sent!',
                            'level': 'success'
                        })
                    })
            },
			show () {
                this.visible = true
                setTimeout(() => {
                	this.modalVisible = true
                }, 100)
            },

            close () {
				this.modalVisible = false
                setTimeout(() => {
					this.visible = false
                }, 200)
            }
        }
	}
</script>