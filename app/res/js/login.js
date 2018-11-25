var login = document.getElementById('login');
var signup = document.getElementById('signup');

// Hide signup by default
signup.hidden = true;

function swapForms() {
	signup.hidden = !signup.hidden;
	login.hidden = !login.hidden;
}