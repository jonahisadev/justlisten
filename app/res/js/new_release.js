var selector = document.getElementById('art');
var image = document.getElementById("art-img");
var counter = document.getElementById("store-count");
var title = document.getElementById("title");
var url = document.getElementById("url");

var stores = 1;

function selectFile() {
	selector.click();
}

function handleFile() {
	var file = this.files[0];
	var reader = new FileReader();

	reader.addEventListener("load", () => {
		image.src = reader.result;
	}, false);

	if (file)
		reader.readAsDataURL(file);
}

function setStoreData(store, index) {
	store.id = "store-" + index;
	store.children[0].id = "store-type-" + index;
	store.children[0].name = "store-type-" + index;
	store.children[1].id = "store-link-" + index;
	store.children[1].name = "store-link-" + index;
	store.children[2].setAttribute("onclick", "removeStoreLink(" + index + ")");
}

function addStoreLink() {
	var lastStore = document.getElementById("store-" + stores);
	var plus = document.getElementById("plus");
	var currentStore = lastStore.cloneNode(true);

	stores++;
	setStoreData(currentStore, stores);

	counter.value = parseInt(stores);

	plus.parentNode.insertBefore(currentStore, plus);
	document.getElementById("store-link-" + stores).value = "";
}

function removeStoreLink(id) {
	if (stores == 1) return;

	// Remove store
	var store = document.getElementById("store-" + id);
	store.parentNode.removeChild(store);

	// Update stores
	for (var i = id+1; i <= stores; i++) {
		setStoreData(document.getElementById("store-" + i), i-1);
	}

	// Update store counter
	stores--;
	counter.value = parseInt(stores);

	// TODO: Shift everything below it
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

function addStores(stores) {
	for (var i = 0; i < stores.length; i++) {
		if (i >= 1) addStoreLink();

		document.getElementById("store-type-" + (i + 1)).selectedIndex = stores[i].name;
		document.getElementById("store-link-" + (i + 1)).value = stores[i].link;
	}
}

function backendPersistStores(stores, id) {
	addStores(JSON.parse(stores).stores);
	var script = document.getElementById("backendPersist");
	script.parentElement.removeChild(script);

	if (id >= 0) {
		var rel = new Release(id, () => {
			document.getElementById("art-img").src = ROOT + "/app/res/img/user_upload/" + rel.art + ".jpg";
		});
	}
}

selector.addEventListener("change", handleFile, false);

title.addEventListener("keyup", (e) => {
	var mod = title.value;

	mod = mod.split(' ').join('-');
	mod = cleanseURL(mod);
	mod = mod.toLowerCase();

	url.value = mod;
}, false);