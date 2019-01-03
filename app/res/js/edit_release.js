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

		addStores(rel.stores);

		Array.from(document.getElementsByClassName("store-link")).forEach((link) => {
			var parent = link.parentElement;
			validateURL(link, parent.children[0].selectedIndex, parent.children[1].value);
		});
	});
}

var url;

function delCallback(data) {
	var json = JSON.parse(data);
	if (json.status == "success") {
		window.location.href = "/";
	}
}

function deleteRelease(fullURL) {
	if (confirm("Are you sure you want to delete this release?")) {
		POST("/a/" + fullURL + "/delete/", {
			"_csrf": document.getElementById("_csrf").value
		}, delCallback);
		url = fullURL;
	}
}