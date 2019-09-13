var Index = {
	instanceVue: undefined,
	Setup: function() {
		Index.instanceVue = new Vue({
			el: '#app',
			data: {
				
			},
			
			created: function() {},
			mounted: function() {
                console.log(123)
            },
			methods: {
				
				clickEstimate: function() {
					console.log('Ping Pong ~');
				},
			},
		});
	},
};

window.onload = function() {
	Index.Setup();
};
