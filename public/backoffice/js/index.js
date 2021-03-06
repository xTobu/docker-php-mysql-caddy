var Index = {
	instanceVue: undefined,
	Setup: function() {
		ELEMENT.locale(ELEMENT.lang.en);
		Index.instanceVue = new Vue({
			el: '#app',
			data: {
				dialogSetting: false,
				sessionData: [
					{
						pkid: 1,
						created_at: '2019-11-29 21:47:05',
						deleted_at: null,
						limit: null,
						session: '總論壇',
						status: 1,
						updated_at: null,
					},
				],
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
				],
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
					if (data.length !== 0 && this.strSearch) {
						var results = [];
						for (var i = 0; i < data.length; i++) {
							var str = '';
							Object.keys(data[i]).forEach(function(item, index, array) {
								if (
									item === 'index' ||
									item === 'event' ||
									item === 'pkid' ||
									item === 'status' ||
									item === 'deleted_at' ||
									item === 'updated_at'
								) {
									return;
								}
								str += data[i][item];
							});
							if (str.toUpperCase().includes(this.strSearch.toUpperCase())) {
								results.push(data[i]);
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
				this.getTableData();
				this.getSessionData();
			},
			methods: {
				logout: function() {
					window.location = '/api/postLogout.php';
				},
				handleSetting: function() {
					this.getSessionData();
					Index.instanceVue.dialogSetting = true;
				},
				handleDownload: function(session) {
					window.location =
						'/api/xlsxExport.php?session=' + Index.instanceVue.selectedSession;
				},
				getTableData: function() {
					axios
						.get('/api/getAttendees.php')
						.then(function(res) {
							res.data.data.forEach(function(item, index, array) {
								item.index = res.data.data.length - index;
							});
							Index.instanceVue.tableData = res.data.data;
						})
						.catch(function(err) {
							console.log(err);
						});
				},
				getSessionData: function() {
					axios
						.get('/api/getSessions.php')
						.then(function(res) {
							Index.instanceVue.sessionData = res.data.data;
							console.log(Index.instanceVue.sessionData);
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
				},
				changeSwitch: function(data) {
					var fd = new FormData();
					fd.append('pkid', data.pkid);
					fd.append('status', data.status);
					axios
						.post('/api/postSessionUpdate.php', fd)
						.then(function(res) {
							console.log(res);
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
