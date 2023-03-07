<template>
    <div>
        <form v-bind:action="action" ref="purchaseForm"  method="POST" class="form-inline">
            <input type="hidden" name="_token" v-bind:value="token">
            <div class="form-group">
                <label for="quantity">Additional Matches ($59.00) x </label>
                <input type="number" id="quantity" v-model="quantity" min="1" name="quantity" class="form-control" style="width: 100px;">
            </div>
            <button type="button" class="btn btn-warning pull-right" @click="showConfirm()">Purchase {{ total }}</button>
        </form>
        <confirm-purchase :visible="showDialog" v-on:confirm="confirm()"></confirm-purchase>
    </div>
</template>

<script>
    import ConfirmPurchuse from './ConfirmPurchase.vue'
	export default {
    	components: {
    		'confirm-purchase': ConfirmPurchuse,
        },
		props: ['cost', 'token', 'action'],
		data() {
			return {
				quantity: 1,
                showDialog: false,
			}
		},
        methods: {
    		showConfirm() {
    			this.$emit('open-confirm-purchase-modal')
            },
	        confirm() {
		        this.$refs.purchaseForm.submit()
	        },
        },
        computed: {
			total() {
				const total = this.quantity * this.cost

				return '$' + total.toFixed(2).replace(/./g, function(c, i, a) {
					return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
				});
            },
        }
	}
</script>