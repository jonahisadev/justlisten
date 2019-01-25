<?php

	include 'model/User.php';
	include 'model/Rel.php';
	include 'model/Beta.php';
	include 'model/Art.php';
	include 'model/Link.php';
	include 'model/Util.php';

	function login_guard() {
		if (!Session::has("login_id")) {
			Session::addFlash("expired");
			View::redirect("/");
		}
	}

	//
	//	MAIN PAGE
	//

	Route::get("/", function() {
		Session::init();

		if (Session::has("login_id")) {
			View::show("home", [
				"username" => Session::get("login_user"),
				"name" => Session::get("login_name")
			]);
		} else {
			if (Session::hasFlash("s_username")) {
				View::show("login", [
					"s_username" => Session::getFlash("s_username"),
					"name" => Session::getFlash("name"),
					"email" => Session::getFlash("email"),
					"beta_code" => Session::getFlash("beta_code")
				]);
			}
			else if (Session::hasFlash("l_username")) {
				View::show("login", [
					"l_username" => Session::getFlash("l_username")
				]);
			} else {
				View::show("login");
			}
		}
	});

	//
	//	NEW RELEASE
	//

	Route::get("/new", function() {
		Session::init();
		login_guard();

		if (Session::hasFlash("error")) {
			View::show("new_release", [
				"name" => Session::get("login_name"),
				"user" => Session::get("login_user"),
				"error" => Session::getFlash("error"),
				"title" => Session::getFlash("title"),
				"url" => Session::getFlash("url"),
				"date" => Session::getFlash("date"),
				"label" => Session::getFlash("label"),
				"type" => Session::getFlash("type"),
				"privacy" => Session::getFlash("privacy")
			]);
			return;
		}

		View::show("new_release", [
			"name" => Session::get("login_name"),
			"a_id" => Session::get("login_id"),
			"user" => Session::get("login_user")
		]);
	});

	Route::spost("/new/create", function() {
		Session::init();
		$user = User::get(Session::get("login_id"));

		// Get some variables
		$title = $_POST['title'];
		$url = Rel::cleanseURL($_POST['url']);
		$date = $_POST['date'];
		$label = $_POST['label'];
		$type = $_POST['type'];
		$privacy = $_POST['privacy'];

		// Verify these aren't empty
		if (empty($title) || empty($url) || empty($date) || empty($label) || $type == 0 || $privacy == 0) {
			$error = "Please fill out all fields!";
		}

		// Make sure URL doesn't already exist
		$temp_r = $user->getRelease($url);
		if ($temp_r->id != NULL) {
			$error = "You already have a release with that URL";
		}

		// Parse stores
		$store_count = $_POST['store-count'];
		$stores = [];
		for ($i = 1; $i <= $store_count; $i++) {
			$stores[] = [$_POST['store-type-'.$i], $_POST['store-link-'.$i]];

			if (!Store::validURL($stores[$i-1][0], $stores[$i-1][1])) {
				$error = "Please enter a valid store URL";
			}
		}

		// Check if album art was uploaded
		if (!empty($_FILES['art']['tmp_name'])) {
			// Save art
			$art = substr(str_shuffle(md5(microtime())), 0, 32);
			$filename = dirname(__FILE__) . "/res/img/user_upload/" . $art . ".jpg";
			$temp_R = Rel::getBy("art", $art);

			// It shouldn't get two in a row
			if ($temp_R->$id != NULL) {
				$art = substr(str_shuffle(md5(microtime())), 0, 32);
				$filename = dirname(__FILE__) . "/res/img/user_upload/" . $art . ".jpg";
			}

			// Check art
			$art_check = Art::meetsRequirements($_FILES['art']);
			if (empty($art_check)) {
				move_uploaded_file($_FILES['art']['tmp_name'], $filename);
			} else {
				$error = $art_check;
			}
		} else {
			$art = "../default";
		}

		// Check error
		if ($error) {
			Session::addFlash("error", $error);
			Session::addFlash("title", $title);
			Session::addFlash("url", $url);
			Session::addFlash("date", $date);
			Session::addFlash("label", $label);
			Session::addFlash("type", $type);
			Session::addFlash("privacy", $privacy);
			Session::addFlash("stores", $stores);
			View::redirect("/new");
		}

		// Generate short link
		$ls = Util::generateID(10);
		if (Link::get($ls) != NULL) {
			$ls = Util::generateID(10);
		}

		// Create the release
		$release = Rel::new([
			"art" => $art,
			"title" => $title,
			"url" => $url,
			"date" => strtotime($date),
			"label" => $label,
			"release_type" => $type,
			"privacy" => $privacy,
			"link" => $ls
		]);
		$release->setStores($stores);
		$release->save();

		// Add release to user's release list
		$user->addRelease($release->id);
		$user->save();

		// Save short link
		$link = Link::new([
			"id" => $ls,
			"url" => $user->username . "/" . $url
		]);
		$link->save();

		Session::addFlash("success_msg", "Release created!");
		View::redirect("/");
	}, FALSE);

	//
	//	EDIT RELEASE
	//

	Route::spost("/a/{username}/{url}/edit/save", function($username, $url) {
		// Get user DBO
		Session::init();
		$user = User::getBy("username", $username);

		// Check the user ID matches the Login ID
		if ($user->id != Session::get("login_id")) {
			View::show("error", [
				"error" => "You're not allowed to be here!"
			]);
			return;
		}

		// Get the release and check its existence
		$R = $user->getRelease($url);
		if ($R == NULL) {
			View::show("error", [
				"error" => "That release doesn't exist"
			]);
			return;
		}

		// Basic variables
		$title = $_POST['title'];
		$url = Rel::cleanseURL($_POST['url']);
		$date = $_POST['date'];
		$label = $_POST['label'];
		$type = $_POST['type'];
		$privacy = $_POST['privacy'];
		
		// Verify these aren't empty
		if (empty($title) || empty($url) || empty($date) || empty($label) || $type == 0 || $privacy == 0) {
			$error = "Please fill out all fields!";
		}

		// Parse stores
		$store_count = $_POST['store-count'];
		$stores = [];
		for ($i = 1; $i <= $store_count; $i++) {
			$stores[] = [$_POST['store-type-' . $i], $_POST['store-link-' . $i]];

			if (!Store::validURL($stores[$i - 1][0], $stores[$i - 1][1])) {
				$error = "Please enter a valid store URL";
			}
		}

		// Upload art
		if (!empty($_FILES['art']['tmp_name'])) {
			// Check art
			$art_check = Art::meetsRequirements($_FILES['art']);
			if (empty($art_check)) {
				$filename = dirname(__FILE__) . "/res/img/user_upload/" . $R->art . ".jpg";
				unlink($filename);

				$R->art = substr(str_shuffle(md5(microtime())), 0, 32);
				$temp_R = Rel::getBy("art", $R->art);
				if ($temp_R->$id != null) {
					$R->art = substr(str_shuffle(md5(microtime())), 0, 32);
				}

				$filename = dirname(__FILE__) . "/res/img/user_upload/" . $R->art . ".jpg";
				move_uploaded_file($_FILES['art']['tmp_name'], $filename);
			} else {
				$error = $art_check;
			}
		}

		// If there's an error, save fields and go back
		if ($error) {
			Session::addFlash("error", $error);
			Session::addFlash("title", $title);
			Session::addFlash("url", $url);
			Session::addFlash("date", $date);
			Session::addFlash("label", $label);
			Session::addFlash("type", $type);
			Session::addFlash("privacy", $privacy);
			Session::addFlash("stores", $stores);
			View::redirect("/a/" . $username . "/" . $url . "/edit");
		}

		// Update short link redirect URL
		$link = Link::get($R->link);
		$link->url = $user->username . "/" . $url;
		$link->save();

		// Save data
		$R->title = $title;
		$R->url = $url;
		$R->date = strtotime($date);
		$R->label = $label;
		$R->release_type = $type;
		$R->privacy = $privacy;
		$R->setStores($stores);
		$R->save();

		Session::addFlash("success_msg", "Release saved!");
		View::redirect("/");
	}, FALSE);

	//
	//	LOGOUT
	//

	Route::get("/logout", function() {
		Session::init();
		Session::destroy();
		setcookie("store", null, -1, '/');	// Delete store cookie
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
			Session::addFlash("l_username", $username);
			View::redirect("/");
		}

		if ($user->verify != "0") {
			Session::init();
			Session::addFlash("bad_verify");
			Session::addFlash("l_username", $username);
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

	Route::post("/signup", function($username, $name, $email, $pass1, $pass2, $beta_code) {
		Session::init();
		Session::addFlash("signup");

		// Check for empty fields
		if (empty($username) || empty($name) || empty($email) || empty($pass1) || empty($pass2) ||
				empty($beta_code)) {
			Session::addFlash("empty");
			$error = TRUE;
		}

		// Email exists
		$temp = User::getBy("email", $email);
		if ($temp->email != NULL) {
			Session::addFlash("bademail");
			$error = TRUE;
		}

		// Username exists
		$temp = User::getBy("username", $username);
		if ($temp->username != NULL) {
			Session::addFlash("username");
			$error = TRUE;
		}

		// Passwords don't match
		if ($pass1 != $pass2) {
			Session::addFlash("passmatch");
			$error = TRUE;
		}

		if (User::cleanseUsername($username) != $username) {
			Session::addFlash("cleanusername");
			$error = TRUE;
		}

		// Check for a beta code
		$beta = Beta::get($beta_code);
		if ($beta->code == NULL) {
			Session::addFlash("nobeta");
			$error = TRUE;
		}

		if ($error) {
			Session::addFlash("s_username", $username);
			Session::addFlash("name", $name);
			Session::addFlash("email", $email);
			Session::addFlash("beta_code", $beta_code);
			View::redirect("/");
		}

		// Hash password
		$password = password_hash($pass1, PASSWORD_ARGON2I);

		// Create verification code
		$verify = substr(str_shuffle(md5(microtime())), 0, 32);

		// Create User
		$user = User::new([
			'username' => $username,
			'name' => $name,
			'email' => $email,
			'password' => $password,
			'verify' => $verify
		]);

		Session::remove("flsh_signup");
		Session::addFlash("verify");
		$beta->delete();
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
			return;
		}

		Session::init();
		View::show("artist", [
			"name" => $user->name,
			"a_id" => $user->id
		]);
	});

	//
	//	EDIT RELEASE
	//

	Route::get("/a/{username}/{url}/edit", function($username, $url) {
		Session::init();
		$user = User::getBy("username", $username);
		if ($user->id == NULL) {
			View::show("error", [
				"error" => "You don't have access to this page!"
			]);
			return;
		}

		if ($user->id != Session::get("login_id")) {
			View::show("error", [
				"error" => "You don't have access to this page!"
			]);
			return;
		}

		$R = $user->getRelease($url);

		if (Session::hasFlash("error")) {
			View::show("edit_release", [
				"name" => Session::get("login_name"),
				"user" => Session::get("login_user"),
				"error" => Session::getFlash("error"),
				"title" => Session::getFlash("title"),
				"url" => Session::getFlash("url"),
				"date" => Session::getFlash("date"),
				"label" => Session::getFlash("label"),
				"type" => Session::getFlash("type"),
				"privacy" => Session::getFlash("privacy"),
				"r_id" => $R->id,
				"a_id" => $user->id
			]);
			return;
		}

		View::show("edit_release", [
			"r_id" => $R->id,
			"a_id" => $user->id
		]);
	});

	//
	//	RELEASE STATS
	//

	Route::get("/a/{username}/{url}/stats", function($username, $url) {
		Session::init();
		$user = User::getBy("username", $username);
		if ($user->id == null) {
			View::show("error", [
				"error" => "You don't have access to this page!"
			]);
			return;
		}

		if ($user->id != Session::get("login_id")) {
			View::show("error", [
				"error" => "You don't have access to this page!"
			]);
			return;
		}

		$R = $user->getRelease($url);

		View::show("release_stats", [
			"r_id" => $R->id,
			"a_id" => $user->id
		]);
	});

	//
	//	GET RELEASE
	//

	Route::get("/a/{username}/{url}", function ($username, $url) {
		if ($url == "edit") {
			return;
		}

		Session::init();
		$user = User::getBy("username", $username);
		if ($user->id == null) {
			View::show("error", [
				"error" => "This release doesn't exist"
			]);
			return;
		}

		$R = $user->getRelease($url);
		if ($R->id == null || ($R->privacy == Rel::PRIV && Session::get("login_id") != $user->id)) {
			View::show("error", [
				"error" => "This release doesn't exist"
			]);
			return;
		}
		
		// Default platform
		if (isset($_COOKIE['store']) && $R->privacy == Rel::PUB) {
			$stores = $R->getStores();
			for ($i = 0; $i < count($stores); $i++) {
				if ($stores[$i][0] == $_COOKIE['store']) {
					$R->logStat($_COOKIE['store']);
					View::redirectGlobal($stores[$i][1]);
					return;
				}
			}
		}

		View::show("release", [
			"r_id" => $R->id,
			"a_id" => $user->id
		]);
	});

	//
	//	DELETE RELEASE
	//
	
	Route::spost("/a/{username}/{url}/delete", function($username, $url) {
		Session::init();
		$user = User::getBy("username", $username);
		if ($user->id == NULL) {
			View::show("error", [
				"error" => "That user doesn't exist"
			]);
			return;
		}

		if ($user->id != Session::get("login_id")) {
			View::show("error", [
				"error" => "You don't have access to this page!"
			]);
			return;
		}

		$R = $user->getRelease($url);
		$user->removeRelease($R->id, dirname(__FILE__));
		$R->delete();

		echo('{ "status": "success" }');
	});

	//
	//	ARTIST EDIT
	//

	Route::get("/a/{username}/edit", function($username) {
		Session::init();
		$user = User::getBy("username", $username);
		if ($user->id == null) {
			View::show("error", [
				"error" => "That user doesn't exist"
			]);
			return;
		}

		if ($user->id != Session::get("login_id")) {
			View::show("error", [
				"error" => "You don't have access to this page!"
			]);
			return;
		}

		View::show("artist_edit", [
			"a_id" => $user->id
		]);
	});

	//
	//	SAVE ARTIST PROFILE
	//

	Route::spost("/a/{username}/edit", function($username) {
		Session::init();
		$user = User::getBy("username", $username);

		if ($user->id != Session::get("login_id")) {
			View::show("error", [
				"error" => "You don't have access to this page!"
			]);
			return;
		}

		// Name
		$name = $_POST['name'];
		if (empty($name)) {
			Session::addFlash("error", "Please fill out all fields");
			View::redirect("/a/" . $username . "/edit");
		}

		// Profile picture
		if (!empty($_FILES['art']['tmp_name'])) {
			$img_check = Art::meetsRequirements($_FILES['art']);
			if (empty($img_check)) {
				if ($user->profile != "profile") {
					$filename = dirname(__FILE__) . "/res/img/user_upload/" . $user->profile . ".jpg";
					unlink($filename);
				}

				$user->profile = substr(str_shuffle(md5(microtime())), 0, 32);
				$filename = dirname(__FILE__) . "/res/img/user_upload/" . $user->profile . ".jpg";
				move_uploaded_file($_FILES['art']['tmp_name'], $filename);
			} else {
				Session::addFlash("error", $img_check);
				View::redirect("/a/" . $username . "/edit");
			}
		}

		// Bio
		$user->bio = filter_var($_POST['bio'], FILTER_SANITIZE_STRING);

		$user->name = $name;
		$user->save();
		View::redirect("/a/" . $user->username . "");
	}, FALSE);

	//
	// RELEASE API
	//

	Route::get("/api/release/{id}", function($id) {
		Session::init();
		$release = Rel::get($id);

		if ($release->id == NULL) {
			echo('{ "error": "No such release" }');
			return;
		}

		// Hide private releases from API GET
		if ($release->privacy == Rel::PRIV) {
			if (Session::has("login_id")) {
				$user = User::get(Session::get("login_id"));
				if (!in_array($release->id, $user->getReleases())) {
					echo ('{ "error": "No such release" }');
					return;
				}
			} else {
				echo ('{ "error": "No such release" }');
				return;
			}
		}

		View::show("api/release", [
			"r_id" => $release->id
		]);
	});

	//
	//	SETTINGS
	//

	Route::get("/settings", function() {
		View::show("settings");
	});

	Route::spost("/settings/password", function($old, $new1, $new2) {
		$user = User::get(Session::get("login_id"));
		if ($user->id == NULL) {
			View::show("error", [
				"error" => "You're not allowed here"
			]);
			return;
		}

		if (empty($old) || empty($new1) || empty($new2)) {
			$error = "Please fill out fields";
		}

		// Verify old password
		if (!$error) {
			if (!password_verify($old, $user->password)) {
				$error = "Incorrect password";
			}
		}

		// Verify new passwords are the same
		if (!$error) {
			if ($new1 != $new2) {
				$error = "New passwords didn't match";
			}
		}

		// There was error
		if ($error) {
			Session::addFlash("error", $error);
			View::redirect("/settings");
			return;
		}

		// Save password
		$password = password_hash($new1, PASSWORD_ARGON2I);
		$user->password = $password;
		$user->save();

		Session::addFlash("success", "Successfully changed password");
		View::redirect("/settings");
	});

	//
	//	REST STORE VALIDATION
	//

	Route::post("/api/validate_store", function($type, $url) {
		echo(Store::validURL($type, $url));
	});

	//
	//	LOG STAT
	//

	Route::post("/api/logstat", function($release_id, $store_id) {
		$R = Rel::get($release_id);
		$R->logStat($store_id);
	});

	//
	//	VERIFY ACCOUNT
	//

	Route::get("/verify_account/{code}", function($code) {
		$user = User::getBy("verify", $code);
		if ($user->id == NULL) {
			View::redirect("/");
		}

		$user->verify = "0";
		$user->save();

		Session::init();
		Session::addFlash("success");
		View::redirect("/");
	});

	//
	//	HARD RESET STORE
	//

	Route::get("/reset", function() {
		View::show("reset_store");
	});

	//
	//	ABOUT
	//

	Route::get("/about", function() {
		View::show("about");
	});

?>