function showShare(id) {
	showModal("share-modal-" + id);
	var input = document.getElementById("share-link-" + id);
	input.focus();
	input.setSelectionRange(0, input.value.length);
}