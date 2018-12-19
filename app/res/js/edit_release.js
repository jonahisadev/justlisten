function loadRelease(id) {
	var rel = new Release(id, () => {
		if (rel.error) {
			console.log(rel.error);
		}

		document.getElementById("title").value = rel.title;
		document.getElementById("url").value = rel.url;
		document.getElementById("date").value = rel.date;
		document.getElementById("label").value = rel.label;
		document.getElementById("type").selectedIndex = rel.release_type;
		document.getElementById("privacy").selectedIndex = rel.privacy;
		document.getElementById("art-img").src = ROOT + "/app/res/img/user_upload/" + rel.art + ".jpg";

		for (var i = 0; i < rel.stores.length; i++) {
			if (i >= 1) addStoreLink();

			document.getElementById("store-type-" + (i+1)).selectedIndex = rel.stores[i].name;
			document.getElementById("store-link-" + (i+1)).value = rel.stores[i].link;
		}
	});
}