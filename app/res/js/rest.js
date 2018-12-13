function GET(url, callback) {
	var req = new XMLHttpRequest();
	req.responseType = "text";
	req.open("GET", ROOT + url);
	req.setRequestHeader("Content-type", "application/json");
	req.setRequestHeader("Accept", "application/json");

	req.onload = () => {
		callback(req.response);
	};

	req.send();
};

function POST(url, data, callback) {
	var req = new XMLHttpRequest();
	req.responseType = "text";
	req.open("POST", ROOT + url);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.setRequestHeader("Accept", "text/html");

	req.onload = () => {
		if (req.readyState == XMLHttpRequest.DONE && req.status == 200) {
			callback(req.response);
		} else {
			console.error("There was a POST issue: " + req + ", " + req.status);
		}
	}

	var content = "";
	for (var prop in data) {
		if (data.hasOwnProperty(prop)) {
			content += prop + "=" + data[prop] + "&";
		}
	}
	content = content.slice(0, -1);
	//console.log(content);
	req.send(content);
}