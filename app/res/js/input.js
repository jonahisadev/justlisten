var inputs = document.querySelectorAll("input");

for (let i = 0; i < inputs.length; i++) {
	let n = inputs[i];
	if (n.type != 'submit') {
		n.addEventListener('keyup', (e) => {
			if (n.value.length > 0)
				addClass(n, "valid");
			else
				removeClass(n, "valid");
		});
	}
}