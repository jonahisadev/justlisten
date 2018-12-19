function store(id, r_id) {
	if (!Cookies.get("store") || Cookies.get("store") == "0")
		Cookies.set("store", id);

	POST("/stat/", {
		"release_id": r_id,
		"store_id": id
	}, (data) => {
		console.log(data);
	});
}