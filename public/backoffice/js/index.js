var Index = {
	instanceVue: undefined,
	Setup: function() {
		Index.instanceVue = new Vue({
			el: '#app',
			data: {
				pageCurrent: 1,
				pageSize: 10,
				pageTotalCount: 100,
				strSearch: '',
				tableData: [
					// {
					// 	pkid: 1,
					// 	event: '下午茶大會',
					// 	session: '胡椒餅',
					// 	name: '俊翔',
					// 	phone: '0988123456',
					// 	email: 'jx@domain.tw',
					// 	status: 1,
					// 	deleted_at: null,
					// 	updated_at: null,
					// 	created_at: '2019-09-14 00:50:54',
					// },
				],
			},
			computed: {
				computedTableData: function() {
					var data = this.tableData;
					if (data.length !== 0 && this.strSearch) {
						var results = [];
						for (var i = 0; i < data.length; i++) {
							for (key in data[i]) {
								if (
									key === 'pkid' ||
									key === 'status' ||
									key === 'deleted_at' ||
									key === 'updated_at'
								) {
									continue;
								}
								if (data[i][key].toString().includes(this.strSearch)) {
									results.push(data[i]);
								}
							}
						}
						return results;
					} else {
						return data;
					}
				},
			},
			created: function() {},
			mounted: function() {
				this.getTableDate();
			},
			methods: {
				logout: function() {
					window.location = '/api/postLogout.php';
				},
				download: function() {
					window.location = '/api/xlsxExport.php';
				},
				getTableDate: function() {
					axios
						.get('/api/getAttendees.php')
						.then(function(res) {
							Index.instanceVue.tableData = res.data.data;
						})
						.catch(function(err) {
							console.log(err);
						});
				},
			},
		});
	},
};

window.onload = function() {
	Index.Setup();
};
