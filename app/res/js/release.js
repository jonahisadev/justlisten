function store(id) {
	if (!Cookies.get("store") || Cookies.get("store") == "0")
		Cookies.set("store", id);
}