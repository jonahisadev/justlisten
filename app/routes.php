<?php

	//
	//	PUT ROUTES IN HERE
	//

	include 'model/User.php';
	include 'model/Rel.php';

	// MAIN PAGE

	Route::get("/", function() {
		Session::init();

		if (Session::has("login_id")) {
			View::show("home", [
				"username" => Session::get("login_user"),
				"name" => Session::get("login_name")
			]);
		} else {
			View::show("login");
		}
	});

	//
	//	NEW RELEASE
	//

	Route::get("/new", function() {
		Session::init();
		View::show("new_release", [
			"name" => Session::get("login_name"),
			"user" => Session::get("login_user")
		]);
	});

	Route::spost("/new/create", function() {
		Session::init();

		// Save art
		$art = substr(str_shuffle(md5(microtime())), 0, 32);
		$filename = dirname(__FILE__) . "/res/img/user_upload/" . $art . ".jpg";
		// TODO: Do some checks

		// Get some variables
		$title = $_POST['title'];
		$url = $_POST['url'];
		$date = $_POST['date'];
		$label = $_POST['label'];
		$type = $_POST['type'];
		// TODO: Make sure these aren't empty

		// Parse stores
		$store_count = $_POST['store-count'];
		$stores = [];
		for ($i = 1; $i <= $store_count; $i++) {
			$stores[] = [$_POST['store-type-'.$i], $_POST['store-link-'.$i]];
		}

		// Create the release
		$release = Rel::new([
			"art" => $art,
			"title" => $title,
			"url" => $url,
			"date" => $date,
			"label" => $label,
			"release_type" => $type
		]);
		$release->setStores($stores);
		$release->save();

		// Add release to user's release list
		$user = User::get(Session::get("login_id"));
		$user->addRelease($release->id);
		$user->save();

		move_uploaded_file($_FILES['art']['tmp_name'], $filename);

		View::redirect("/");
	}, FALSE);

	//
	//	LOGOUT
	//

	Route::get("/logout", function() {
		Session::init();
		Session::destroy();
		View::redirect("/");
	});

	//
	// LOGIN
	//

	Route::post("/login", function($username, $password) {
		// Empty fields
		if (empty($username) || empty($password)) {
			Session::init();
			Session::addFlash("empty");
			View::redirect("/");
		}

		$user = User::getBy("username", $username);

		// Bad username or password
		if ($user->username == NULL || !password_verify($password, $user->password)) {
			Session::init();
			Session::addFlash("bad");
			View::redirect("/");
		}

		Session::init([
			'login_id' => $user->id,
			'login_user' => $user->username,
			'login_name' => $user->name
		]);
		csrf_create();
		View::redirect("/");
	});

	//
	//	SIGN UP
	//

	Route::post("/signup", function($username, $name, $email, $pass1, $pass2) {
		Session::init();
		Session::addFlash("signup");

		// Check for empty fields
		if (empty($username) || empty($name) || empty($email) || empty($pass1) || empty($pass2)) {
			Session::addFlash("empty");
			View::redirect("/");
		}

		// Email exists
		$temp = User::getBy("email", $email);
		if ($temp->email != NULL) {
			Session::addFlash("email");
			View::redirect("/");
		}

		// Username exists
		$temp = User::getBy("username", $username);
		if ($temp->username != NULL) {
			Session::addFlash("username");
			View::redirect("/");
		}

		// Passwords don't match
		if ($pass1 != $pass2) {
			Session::addFlash("passmatch");
			View::redirect("/");
		}

		// Hash password
		$password = password_hash($pass1, PASSWORD_ARGON2I);

		// Create User
		$user = User::new([
			'username' => $username,
			'name' => $name,
			'email' => $email,
			'password' => $password
		]);

		Session::remove("flsh_signup");
		Session::addFlash("success");
		View::redirect("/");
	});

	//
	//	ARTIST PAGE
	//

	Route::get("/a/{username}", function($username) {
		$user = User::getBy("username", $username);
		if ($user->id == NULL) {
			View::show("error", [
				"error" => "The user '" . $username . "' doesn't exist :("
			]);
		}

		Session::init();
		View::show("artist", [
			"name" => $user->name,
			"a_id" => $user->id
		]);
	});

	//
	//	GET RELEASE
	//

	Route::get("/a/{username}/{url}", function($username, $url) {
		$user = User::getBy("username", $username);
		if ($user->id == NULL) {
			echo("No such username '" . $username . "'");
			die();
		}

		$rels = $user->getReleases();
		for ($i = 0; $i < count($rels); $i++) {
			$R = Rel::get($rels[$i]);
			if ($R->url == $url) {
				break;
			}
		}

		View::show("release", [
			"r_id" => $R->id,
			"a_id" => $user->id
		]);
	});

	//
	//	ABOUT
	//

	Route::get("/about", function() {
		View::show("about");
	});

?>