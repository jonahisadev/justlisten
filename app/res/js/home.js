var url;

function delCallback(data) {
	var json = JSON.parse(data);
	if (json.status == "success") {
		var container = document.getElementById(url);
		container.parentNode.removeChild(container);
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