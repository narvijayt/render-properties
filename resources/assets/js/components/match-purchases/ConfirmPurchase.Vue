<template>
    <div v-if="visible">
        <div class="modal fade purchase-match-confirm-dialog" :class="{ 'in': modalVisible }" tabindex="-1" role="dialog" id="confirm-submit-modal" v-if="visible" @click.self="close()">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close()"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirm</h4>
                    </div>
                    <div class="modal-body">
                        <p id="confirm-submit-modal-message">Are sure you wish to purchase additional matches?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" @click="close()">Close</button>
                        <button type="button" class="btn btn-primary" id="confirm-submit-modal-accept" aria-label="Yes" @click="confirm()">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .purchase-match-confirm-dialog {
        display: block;
    }
</style>

<script>
export default {
    data() {
		return {
            visible: false,
            modalVisible: false,
        }
    },
    created() {
	    this.$parent.$on('open-confirm-purchase-modal', () => {
		    this.visible = true
		    setTimeout(() => {
			    this.modalVisible = true
		    }, 100)
	    })
    },
    methods: {
    	confirm() {
    		this.$emit('confirm')
        },
    	close() {
		    this.modalVisible = false
		    setTimeout(() => {
			    this.visible = false
		    }, 200)
        }
    }
}
</script>