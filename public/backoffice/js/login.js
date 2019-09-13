var Login = {
	instanceVue: undefined,
	Setup: function() {
		Login.instanceVue = new Vue({
			el: '#app',
			data: {
				user: '',
				pwd: '',
			}
		});
	},
};

window.onload = function() {
	Login.Setup();
};
