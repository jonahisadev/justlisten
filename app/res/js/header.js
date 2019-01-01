function setHeaderStore() {
	if (!Cookies.get("store")) return;
	var store = parseInt(Cookies.get("store"));
	if (store == 0) {
		removeHeaderStore();
		return;
	}

	removeHeaderStore();

	var title = document.getElementById("jl-title");
	title.innerHTML += '<span id="divider"> - </span><span id="current-store" onclick="headerClick()">';
	var placeholder = title.childNodes[2];

	switch (store) {
		case 1:
			placeholder.innerHTML += "Spotify";
			break;
		case 2:
			placeholder.innerHTML += "Apple Music";
			break;
		case 3:
			placeholder.innerHTML += "iTunes";
			break;
		case 4:
			placeholder.innerHTML += "Soundcloud";
			break;
		case 5:
			placeholder.innerHTML += "YouTube";
			break;
		case 6:
			placeholder.innerHTML += "Deezer";
			break;
		case 7:
			placeholder.innerHTML += "Amazon";
			break;
		case 8:
			placeholder.innerHTML += "Google Play";
			break;
		case 9:
			placeholder.innerHTML += "Bandcamp";
			break;
	}

	title.innerHTML += "</span>";
}

function removeHeaderStore() {
	var e;
	if ((e = document.getElementById("current-store"))) {
		e.parentNode.removeChild(document.getElementById("divider"));
		e.parentNode.removeChild(e);
	}
}

function setStoreManually() {
	Cookies.set("store", document.getElementById("store-selector").selectedIndex);
	setHeaderStore();
	hideModal("store-modal");
}

function headerClick() {
	if (Cookies.get("store")) {
		document.getElementById("store-selector").selectedIndex = parseInt(Cookies.get("store"));
	}
	showModal("store-modal");
}

setHeaderStore();