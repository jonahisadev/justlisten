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
		document.getElementById("art-img").src = "https://assets.justlisten.me/" + rel.art + ".jpg";

		addStores(rel.stores);
	});
}

var url;

function delCallback(data) {
	console.log(data);
	var json = JSON.parse(data);
	if (json.status == "success") {
		window.location.href = ROOT + "/dashboard";
	} else {
		window.alert(json.msg);
	}
}

function deleteRelease(fullURL) {
	if (confirm("Are you sure you want to delete this release?")) {
		_().ajax(ROOT + "/a/" + fullURL + "/delete/", {
			method: "POST",
			async: true,
			contentType: "application/x-www-form-urlencoded",
			success: (msg) => {
				delCallback(msg);
			},
			failure: (msg, code) => {
				window.alert(code + ": " + msg);
			},
			data: { "_csrf": _("#_csrf").val() }
		});
		url = fullURL;
	}
}