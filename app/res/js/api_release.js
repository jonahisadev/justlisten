class Release {
	constructor(id, cb) {
		GET("/api/release/" + id + "/", (json) => {
			var data = JSON.parse(json);
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
		});
	}
};