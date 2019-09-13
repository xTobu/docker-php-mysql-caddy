var Index = {
	instanceVue: undefined,
	Setup: function() {
		Index.instanceVue = new Vue({
			el: '#app',
			data: {
				tableData: [
					{
						date: '2016-05-03',
						name: '王小虎',
						address: '上海市普陀区金沙江路 1518 弄',
					},
					{
						date: '2016-05-02',
						name: '王小虎',
						address: '上海市普陀区金沙江路 1518 弄',
					},
					{
						date: '2016-05-04',
						name: '王小虎',
						address: '上海市普陀区金沙江路 1518 弄',
					},
					{
						date: '2016-05-01',
						name: '王小虎',
						address: '上海市普陀区金沙江路 1518 弄',
					},
					{
						date: '2016-05-08',
						name: '王小虎',
						address: '上海市普陀区金沙江路 1518 弄',
					},
					{
						date: '2016-05-06',
						name: '王小虎',
						address: '上海市普陀区金沙江路 1518 弄',
					},
					{
						date: '2016-05-07',
						name: '王小虎',
						address: '上海市普陀区金沙江路 1518 弄',
					}
				],
			},

			created: function() {},
			mounted: function() {
			},
			methods: {
				logout: function() {
					window.location = '/api/postLogout.php';
				},
			},
		});
	},
};

window.onload = function() {
	Index.Setup();
};
