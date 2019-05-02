var STORE_COUNT = 0;

//
// FILE HANDLER
//

var selector = document.getElementById('art');
var image = document.getElementById("art-img");

function selectFile() {
	selector.click();
}

function resetImage(temp) {
	image.src = temp;
	selector.value = "";
}

function handleFile() {
	var file = this.files[0];
	var reader = new FileReader();

	reader.addEventListener("load", () => {
		var temp = image.src;
		image.src = reader.result;

		setTimeout(() => {
			console.log(file.size + ", " + 2 * 1024 * 1024);

			if (image.width != image.height) {
				resetImage(temp);
				window.alert("Please use a square image");
			}

			else if (file.size > 2 * 1024 * 1024) {
				resetImage(temp);
				window.alert("Max image size is 2MB - " + (file.size / (1024 * 1024)).toFixed(2) + "MB");
			}
		}, 100);
	}, false);

	if (file)
		reader.readAsDataURL(file);
}

function validateURL(id, type, url) {
	var data = {
		"type": type,
		"url": url
	};

	_().ajax(ROOT + "/api/validate_store/", {
		method: "POST",
		async: true,
		contentType: "application/x-www-form-urlencoded",
		success: (msg) => {
			if (msg == 0) {
				_("#store-link-" + id).addClass("invalid").removeClass("valid");
			}
			else {
				_("#store-link-" + id).addClass("valid").removeClass("invalid");
			}
		},
		data: data
	});
}

function addStore() {
	STORE_COUNT++;
	var count = STORE_COUNT;
	
	var store_container = _().create("div", { className: "store", id: "store-" + count });
	var arrow_right = _().create("div", { className: "arrow-right" });
	store_container.append(arrow_right);
	var store_label = _().create("h2", { innerText: "Store", id: "store-header-" + count });
	store_container.append(store_label);

	var store_nav = _().create("div", { className: "store-nav" });
	store_nav.append(_().create("div", { className: "arrow-up" }));
	store_nav.append(_().create("div", { className: "arrow-down" }));
	store_container.append(store_nav);

	var store_data = _().create("div", { className: "store-data" });
	var store_type = _().create("select", {
		className: "store-type",
		name: "store-type-" + count,
		id: "store-type-" + count,
		innerHTML: STORES
	});
	store_data.append(store_type);
	store_data.append(_().create("input", {
		className: "store-link",
		name: "store-link-" + count,
		id: "store-link-" + count,
		type: "text"
	}));
	var store_remove = _().create("div", {
		className: "store-remove",
		id: "store-remove-" + count,
		innerHTML: "&times;"
	});
	store_data.append(store_remove);
	store_container.append(store_data);

	_("#plus").before(store_container);
	_("#store-count").set({ value: STORE_COUNT });
	setEventListeners(count);
}

function swapStore(a, b) {
	var store_a = _("#store-" + a);
	var store_b = _("#store-" + b);

	// Down
	if (a < b) {
		var a_copy = new DOMElement(store_a.raw.cloneNode(true));
		var type_index = _("#store-type-" + a).raw.selectedIndex;
		store_a.remove();
		setStoreID(b, 0);
		store_b.after(a_copy);
		setStoreID(a, b);
		setStoreID(0, a);
		_("#store-type-" + b).raw.selectedIndex = type_index;
	}
	// Up
	else {
		var b_copy = new DOMElement(store_b.raw.cloneNode(true));
		var type_index = _("#store-type-" + b).raw.selectedIndex;
		store_b.remove();
		setStoreID(a, 0);
		store_a.after(b_copy);
		setStoreID(b, a);
		setStoreID(0, b);
		_("#store-type-" + a).raw.selectedIndex = type_index;
	}

	setEventListeners(a);
	setEventListeners(b);
}

function removeStore(id) {
	if (STORE_COUNT > 1) {
		_("#store-" + id).remove();
		STORE_COUNT--;
		_("#store-count").set({ value: STORE_COUNT });
	}
}

function setStoreID(old, id) {
	_("#store-" + old).id = "store-" + id;

	_("#store-link-" + old).set({
		id: "store-link-" + id,
		name: "store-link-" + id
	});

	_("#store-type-" + old).set({
		id: "store-type-" + id,
		name: "store-type-" + id
	});

	_("#store-remove-" + old).id = "store-remove-" + id;
}

function setEventListeners(id) {
	var store = _("#store-" + id);
	var arrow_right = new DOMElement(store.raw.children[0]);
	var store_data = new DOMElement(store.raw.children[3]);
	var store_type = new DOMElement(store_data.raw.children[0]);
	var store_link = new DOMElement(store_data.raw.children[1]);
	var store_label = new DOMElement(store.raw.children[1]);
	var arrow_up = new DOMElement(store.raw.children[2].children[0]);
	var arrow_down = new DOMElement(store.raw.children[2].children[1]);

	arrow_right.on("click", () => {
		arrow_right.toggleClass("down");
		store.toggleClass("open");
		store_data.toggleClass("show");
	});

	_("#store-remove-" + id).on("click", () => {
		removeStore(id);
	});

	store_type.on("change", () => {
		store_label.set({ innerText: store_type.raw.options[store_type.val()].innerText });
		validateURL(id, store_type.raw.selectedIndex, store_link.val());
	});

	store_link.on("blur", () => {
		validateURL(id, store_type.raw.selectedIndex, store_link.val());
	});

	arrow_up.on("click", () => {
		if (id > 1) {
			swapStore(id, id - 1)
		}
	});

	arrow_down.on("click", () => {
		if (id < STORE_COUNT) {
			swapStore(id, id + 1);
		}
	});
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
		addStore();

		// document.getElementById("store-type-" + (i + 1)).selectedIndex = stores[i].name;
		// document.getElementById("store-link-" + (i + 1)).value = stores[i].link;

		var store_type = _("#store-type-" + (i + 1));
		store_type.raw.selectedIndex = stores[i].name;
		_("#store-link-" + (i + 1)).raw.value = stores[i].link;
		_("#store-header-" + (i + 1)).set({ innerText: store_type.raw.options[store_type.val()].innerText });
		validateURL((i + 1), stores[i].name, stores[i].link)
	}
}

function backendPersistStores(stores, id) {
	addStores(JSON.parse(stores).stores);
	// Array.from(document.getElementsByClassName("store-link")).forEach((link) => {
	// 	var parent = link.parentElement;
	// 	validateURL(link, parent.children[0].selectedIndex, parent.children[1].value);
	// });

	_("#backendPersist").remove();

	if (id >= 0) {
		var rel = new Release(id, () => {
			document.getElementById("art-img").src = "https://assets.justlisten.me/" + rel.art + ".jpg";
		});
	}
}

selector.addEventListener("change", handleFile, false);
_("#title").on("keyup", () => {
	var mod = _("#title").val();

	mod = mod.split(' ').join('-');
	mod = cleanseURL(mod);
	mod = mod.toLowerCase();

	_("#url").raw.value = mod;
});