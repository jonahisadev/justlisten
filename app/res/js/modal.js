function showModal(id) {
	var modal = document.getElementById(id);
	modal.style.display = "block";
}

function hideModal(id) {
	if (typeof id != "string") {
		id.style.display = "none";
	} else {
		var modal = document.getElementById(id);
		modal.style.display = "none";
	}
}

Array.from(document.getElementsByClassName("modal")).forEach((modal) => {
	window.onclick = (event) => {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
});

window.addEventListener("keydown", (e) => {
	if (e.key == "Escape") {
		Array.from(document.getElementsByClassName("modal")).forEach((modal) => {
			modal.style.display = "none";
		});
	}
});