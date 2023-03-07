require('./bootstrap')

window.Vue = require('vue')

window.EventBus = new Vue({})

window.Flash = message => {
	window.EventBus.$emit('flash', message)
}

window.parseUTCDate = date => {
    return moment.tz(date, 'YYYY-MM-DD HH:mm:ss', 'UTC');
}

window.parseUTCToLocalDate = date => {
	return window.parseUTCDate(date).local()
}

Vue.component('flash-messages', require('./components/flash/FlashMessages.vue'))
Vue.component('send-message', require('./components/send-message/SendMessage.vue'))
Vue.component('message-center', require('./components/message-center/MessageCenter.vue'))
Vue.component('purchase-additional-matches', require('./components/match-purchases/PurchaseAdditionalMatches.vue'))

import store from './lib/global-store'
import { transformConversation } from './lib/message-center/store'

window.app = new Vue({
    el: '#app',
    data: {
        shared_state: store.state
    },
    beforeMount () {
    	if (window.user) {
		    this.shared_state.user = window.user

		    this.shared_state.userSocket = Echo.private(`App.User.${this.shared_state.user.user_id}`)
		    this.shared_state.userSocket.listen('Conversation.NewMessageNotifyUser', event => {
			    const message = event.data
			    if (message.user_id !== this.shared_state.user.user_id) {
				    Flash({
					    'message': `New message received from ${message.user_name}`,
					    'level': 'info'
				    })
			    }

			    EventBus.$emit('message-center.new-message', message)
		    })
		    this.shared_state.userSocket.listen('Conversation.NewConversation', event => {
			    const conversation = transformConversation(event.data)
			    if (conversation.user_id !== this.shared_state.user.user_id) {

				    Flash({
					    message: `New conversation with ${conversation.recipient.first_name} ${conversation.recipient.last_name} created`,
					    level: 'info'
				    })
			    }
			    EventBus.$emit('message-center.new-conversation', conversation)
		    })
	    }
    }
})




// $('div.alert').not('.alert-important').delay(3000).fadeOut(350)

$('.datepicker').datepicker({
    startView: 2,
    minViewMode: 0,
    maxViewMode: 3,
    forceParse: true,
    format: 'MM d, yyyy'
    // format: {
    //  toDisplay: function (date, format, language) {
    //      var d = new Date(date)
    //      d.setDate(d.getDate() - 7)
    //      return d.toISOString()
    //  },
    //  toValue: function (date, format, language) {
    //      var d = new Date(date)
    //      d.setDate(d.getDate() + 7)
    //      return new Date(d)
    //  }
    // }
})

$('[data-politespace]').politespace()
console.log('initializing politespace')

$(document).ready(function () {
    // $('#flash-overlay-modal').modal()

    const $avatarUploadForm = $('#user-profile-avatar-upload-form')
    const $avatarUploadFileField = $('#user-profile-avatar-file')
    const $avatarUploadButton = $('#user-profile-avatar-upload')

    $avatarUploadButton.on('click', function () {
        $avatarUploadFileField.trigger('click')
    })

    $avatarUploadFileField.on('change', function () {
        var files = $(this)[0].files

        if (files.length === 1) {
            $avatarUploadForm.submit()
        }
    })

	// Allow confirmation of button clicks the button needs the following data attributes
	// to not only open the modal dialog but to customize it for the form that it needs
	// to submit:
    // <button
	//      type="button"
	//      data-toggle="modal"
	//      data-confirm-submit="#reject-renew-match-{{ $match->match_id }}"
	//      data-confirm-message="Are you sure you wish to reject the match renewal with {{ $oppUser->full_name() }}"
	//      data-target="#confirm-submit-modal"
	// >Reject</button>

	$('#confirm-submit-modal').on('show.bs.modal', function(event) {
		var $button = $(event.relatedTarget)
		var submitTarget = $button.data('confirm-submit')
		var message = $button.data('confirm-message')

		if(message !== '') {
			$('#confirm-submit-modal-message').html(message)
		}

		$("#confirm-submit-modal-accept").on('click', function() {
			$(submitTarget).submit()
		})
	})
})



