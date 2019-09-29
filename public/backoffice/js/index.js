var Index = {
	instanceVue: undefined,
	Setup: function() {
		ELEMENT.locale(ELEMENT.lang.en);
		Index.instanceVue = new Vue({
			el: '#app',
			data: {
				pageCurrent: 1,
				pageSize: 10,
				pageTotalCount: 100,
				strSearch: '',
				selectedSession: '全部',
				tableData: [
					// {
					// 	pkid: 1,
					// 	event: 'Event',
					// 	session: '台中場',
					// 	job: '職稱',
					// 	dept: '所屬單位',
					// 	rocid: 'A123456789',
					// 	name: '俊翔',
					// 	phone: '0988123456',
					// 	email: 'jx@domain.tw',
					// 	status: 1,
					// 	deleted_at: null,
					// 	updated_at: null,
					// 	created_at: '2019-09-14 00:50:54',
					// },
				]
			},
			computed: {
				computedTableData: function() {
					var _s = this.selectedSession;
					var data = this.tableData.filter(function(item, index, array) {
						if (_s === '全部') {
							return true;
						} else {
							return _s == item.session;
						}
					});

					data.forEach(function(item, index, array) {
						item.index = index + 1;
					});
					if (data.length !== 0 && this.strSearch) {
						var results = [];
						for (var i = 0; i < data.length; i++) {
							var str = '';
							Object.keys(data[i]).forEach(function(item, index, array) {
								if (
									item === 'index' ||
									item === 'pkid' ||
									item === 'status' ||
									item === 'deleted_at' ||
									item === 'updated_at'
								) {
									return;
								}
								str += data[i][item].toString();
							});
							if (str.toUpperCase().includes(this.strSearch.toUpperCase())) {
								results.push(data[i]);
							}
						}
						return results;
					} else {
						return data;
					}
				}
			},
			created: function() {},
			mounted: function() {
				this.getTableDate();
			},
			methods: {
				logout: function() {
					window.location = '/api/postLogout.php';
				},
				handleDownload: function(session) {
					window.location = '/api/xlsxExport.php?session=' + Index.instanceVue.selectedSession;
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
				handleSizeChange: function(val) {
					Index.instanceVue.pageSize = val;
				},
				updateSearch: function(value) {
					this.strSearch = value;
				}
			}
		});
	}
};

window.onload = function() {
	Index.Setup();
};
