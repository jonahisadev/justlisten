function store(id, r_id, url) {
	if (!Cookies.get("store") || Cookies.get("store") == "0")
		Cookies.set("store", id);

	POST("/api/logstat", {
		"release_id": r_id,
		"store_id": id
	}, (data) => {
		window.location.href = url;
	});
}