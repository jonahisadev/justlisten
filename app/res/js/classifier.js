// -----------------------------------------
//
//	          Classifier 1.0
//
//    Copyright (c) 2018 Jonah Alligood
//
// -----------------------------------------

function addClass(e, cls) {
	if (hasClass(e, cls)) return false;

	if (emptyClass(e))
		e.setAttribute("class", cls);
	else
		e.setAttribute("class", e.getAttribute("class") + " " + cls);

	return true;
}

function removeClass(e, cls) {
	// Empty class
	if (emptyClass(e)) return false;

	// Just one class
	else if (e.getAttribute("class") == cls)
		e.setAttribute("class", "");

	// First class (haha)
	else if (e.getAttribute("class").startsWith(cls + " "))
		e.setAttribute("class", e.getAttribute("class").replace(cls + " ", ""));

	// Anything else
	else
		e.setAttribute("class", e.getAttribute("class").replace(" " + cls, ""));

	if (emptyClass(e))
		e.removeAttribute("class");

	return true;
}

function hasClass(e, cls) {
	if (emptyClass(e)) return false;
	if (e.getAttribute("class").startsWith(cls + " ") ||				// class='cls other'
		e.getAttribute("class").endsWith(" " + cls) ||					// class='other class'
		e.getAttribute("class").includes(" " + cls + " ") ||			// class='x cls y'
		e.getAttribute("class") == cls) {								// class='cls'
		return true;
	}
	return false;
}

function emptyClass(e) {
	if (e.getAttribute("class") == null || e.getAttribute("class") == "")
		return true;
	return false;
}