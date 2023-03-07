<template>
    <transition name="transition__fade" v-on:after-leave="afterLeave">
        <div v-if="show" class="alert" :class="'alert-' + level" role="alert">
            <strong>{{ levelTitle }}!</strong> {{ body }}
        </div>
    </transition>
</template>

<script>
export default {
	props: ['message', 'index'],
	data() {
		return {
			body: '',
			level: '',
			levelTitle: '',
			show: true
		}
	},
	created() {
		if (this.message) {
			this.flash(this.message)

			this.hide()
		}
	},
	methods: {
		titleCase(sentence) {
			return sentence.split(' ').map(word => {
				return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
			}).join(' ')
		},

		flash(message) {
			this.body = message.message
			this.level = message.level
			this.levelTitle = this.titleCase(this.level)
		},

		hide() {
			setTimeout(() => {
				this.show = false
			}, 5000)
		},

		afterLeave() {
			this.$emit('deleteMessage')
		},
	}
}
</script>