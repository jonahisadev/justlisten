var login = document.getElementById('login');
var signup = document.getElementById('signup');

// Hide signup by default

function swapForms() {
	signup.hidden = !signup.hidden;
	login.hidden = !login.hidden;
}