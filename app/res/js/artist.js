function showShare() {
	showModal("share-modal");
	var input = document.getElementById("share-link");
	input.focus();
	input.setSelectionRange(0, input.value.length);
}