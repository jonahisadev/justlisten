class Release {
	constructor(id, cb) {
		_().ajax(ROOT + "/api/release/" + id + "/", {
			method: "GET",
			async: true,
			contentType: "application/json",
			success: (msg) => {
				var data = JSON.parse(msg);
				if (data.error) {
					this.error = data.error;
					return;
				}

				this.title = data.title;
				this.art = data.art;
				this.url = data.url;
				this.date = data.date;
				this.label = data.label;
				this.release_type = data.release_type;
				this.stores = data.stores;
				this.privacy = data.privacy;

				cb();
			},
			failure: (msg, code) => {
				console.error(code);
			}
		});
	}
};