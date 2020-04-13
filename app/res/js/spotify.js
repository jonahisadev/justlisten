const ACCESS_TOKEN = document.getElementById("access_token").value;
const FORM = document.getElementById("spotify-releases");

var RELEASE_COUNT = -1;
var SUCCESS_COUNT = 0;

document.getElementById("send_spotify").onclick = (e) => {
	var artist_id = document.getElementById("artist_id").value.split("spotify:artist:")[1];
	spotify_get("https://api.spotify.com/v1/artists/" + artist_id + "/albums?include_groups=album,single&market=ES", (res) => handle_albums(JSON.parse(res)));
};

document.getElementById("save-btn").onclick = (e) => save_all_albums();

function handle_albums(data) {
	// Artist Info
	var artist_info = document.getElementById("spotify-artist-info");

	// Artist Name
	var artist_name = document.createElement("h2");
	artist_name.innerText = data.items[0].artists[0].name;
	artist_info.appendChild(artist_name);

	// Artist Profile
	var artist_profile = document.createElement("img");
	spotify_get(data.items[0].artists[0].href, (res) => {
		var artist_data = JSON.parse(res);
		artist_profile.src = artist_data.images[0].url;
		artist_profile.width = 150;
		artist_profile.className = "img-upload";
		artist_info.appendChild(artist_profile);
	});

	for (var i = 0; i < data.items.length; i++) {
		var item = data.items[i];
		spotify_get(item.href, (res) => {
			var album_data = JSON.parse(res);
			var album = create_album(album_data, i);
			add_album_dom(album);
		});
	}
	document.getElementById("spotify-save").hidden = false;
	RELEASE_COUNT = data.items.length;

	// Disable import button
	document.getElementById("send_spotify").style = "display: none;";
}

function create_album(album_data, index) {
	var album = new Array();
	album['index'] = index;

	// Art URL
	album['art'] = album_data.images[0].url;

	// Album Title
	album['title'] = album_data.name;

	// TODO: url slug

	// Release Date
	if (album_data.release_date_precision == "day") {
		album['release_date'] = album_data.release_date;
	} else if (album_data.release_date_precision == "month") {
		album['release_date'] = album_data.release_date + "-01";
	} else {
		album['release_date'] = album_data.release_date = "-01-01";
	}

	// P-Line
	album['p_line'] = album_data.copyrights[1].text.substring(5, album_data.copyrights[1].text.length);

	// Release Type
	album['release_type'] = get_release_type(album_data.total_tracks);

	// Store Link
	album['store_link'] = album_data.external_urls.spotify;

	return album;
}

function get_release_type(track_length) {
	if (track_length <= 3) {
		return "1";
	} else if (track_length <= 7) {
		return "2";
	} else {
		return "3";
	}
}

function add_album_dom(album) {
	var index = album['index'];

	var container = document.createElement("div");
	container.id = "release-" + index;
	container.className = "release";

	// Title
	var title = document.createElement("h3");
	title.innerText = album['title'];
	title.id = "title-" + index;
	container.appendChild(title);

	// Art
	var art = document.createElement("img");
	art.src = album['art'];
	art.className = "img-upload"
	art.id = "art-" + index;
	art.width = 200;
	container.appendChild(art);
	// TODO: FIGURE THIS OUT AS FAR AS UPLOADING GOES

	// Release Date Label
	var release_date_label = document.createElement("h5");
	release_date_label.innerText = "Release Date";
	release_date_label.style = "margin: 5px;"
	container.appendChild(release_date_label);

	// Release Date
	var release_date = document.createElement("input");
	release_date.type = "date";
	release_date.value = album['release_date'];
	release_date.style = "width: 90%;";
	release_date.id = "date-" + index;
	container.appendChild(release_date);

	// Hidden fields
	var url = document.createElement("input");
	url.type = "hidden";
	url.value = title_to_url(album['title']);
	url.id = "url-" + index;
	container.appendChild(url);

	var p_line = document.createElement("input");
	p_line.type = "hidden";
	p_line.value = album['p_line'];
	p_line.id = "pline-" + index;
	container.appendChild(p_line);

	var release_type = document.createElement("input");
	release_type.type = "hidden";
	release_type.value = album['release_type'];
	release_type.id = "type-" + index;
	container.appendChild(release_type);

	var store_link = document.createElement("input");
	store_link.type = "hidden";
	store_link.value = album['store_link'];
	store_link.id = "link-" + index;
	container.appendChild(store_link);

	// Add the DIV to the form
	FORM.appendChild(container);
}

function save_all_albums() {
	for (var i = 0; i < RELEASE_COUNT; i++) {
		save_album(i);
	}
}

function save_album(index) {
	var params = {
		'title': document.getElementById("title-" + index).innerText,
		'url': document.getElementById("url-" + index).value,
		'date': document.getElementById("date-" + index).value,
		'label': document.getElementById("pline-" + index).value,
		'type': document.getElementById("type-" + index).value,
		'privacy': document.getElementById("privacy-check").checked ? 1 : 2,
		'store-count': 1,
		'store-type-1': 1,
		'store-link-1': document.getElementById("link-" + index).value,

		'ajax_art': document.getElementById("art-" + index).src,
		'ajax': 'true',
		'_csrf': document.getElementById("_csrf").value
	};

	POST('/dashboard/new/create', params, (res) => {
		console.log(res);
		var data = JSON.parse(res);
		if (data.status == "error") {
			// window.alert("Release " + index + ": " + data.msg);
			console.log(data);
		} else if (data.status == "success") {
			// TODO: Get rid of this, we don't need it
			console.log("Successfully created release " + index + "!");
			SUCCESS_COUNT++;
		}
	});
}

function spotify_get(url, cb) {
	var clean_url = encodeURI(url);
	var req = new XMLHttpRequest();
	req.open("GET", clean_url, false);

	req.setRequestHeader("Content-Type", "application/json");
	req.setRequestHeader("Authorization", "Bearer " + ACCESS_TOKEN);

	req.onreadystatechange = () => {
		if (req.readyState === XMLHttpRequest.DONE) {
			if (req.status === 200) {
				cb(req.responseText);
			} else {
				window.alert("Spotify API Error: " + req.status);
			}
		}
	};

	req.send();
};

function title_to_url(title) {
	var mod = title;

	mod = mod.split(' ').join('-');
	mod = cleanseURL(mod);
	mod = mod.toLowerCase();

	return mod;
}

function cleanseURL(url) {
	var str = "";
	for (var i = 0; i < url.length; i++) {
		var c = url.charAt(i);
		if ((c >= 'A' && c <= 'Z') || (c >= 'a' && c <= 'z') || (c >= '0' && c <= '9') || c == '-') {
			str += c;
		}
	}
	return str;
}

setInterval(() => {
	if (SUCCESS_COUNT == RELEASE_COUNT) {
		window.alert("Successfully imported releases!");
		window.location.href = ROOT + "/dashboard";
	}
}, 500);