
var profileForm = new Vue({
	el: '#profile-sales',
	data: {
		sales: [{
			year: '',
			month: '',
			total_sales: ''
		}]
	},
	methods: {
		addEntry: function () {
			this.sales.push({
				year: '',
				month: '',
				total_sales: ''
			})
		}
	}

})