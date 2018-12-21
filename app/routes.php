<?php

	include 'model/User.php';
	include 'model/Rel.php';
	include 'model/Beta.php';

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
		$privacy = $_POST['privacy'];
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
			"date" => strtotime($date),
			"label" => $label,
			"release_type" => $type,
			"privacy" => $privacy
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

		// Upload art
		if ($_FILES['art']['tmp_name'] != "") {
			$filename = dirname(__FILE__) . "/res/img/user_upload/" . $R->art . ".jpg";
			unlink($filename);

			$R->art = substr(str_shuffle(md5(microtime())), 0, 32);
			$filename = dirname(__FILE__) . "/res/img/user_upload/" . $R->art . ".jpg";
			move_uploaded_file($_FILES['art']['tmp_name'], $filename);
		}

		$title = $_POST['title'];
		$url = $_POST['url'];
		$date = $_POST['date'];
		$label = $_POST['label'];
		$type = $_POST['type'];
		$privacy = $_POST['privacy'];
		// TODO: Make sure these aren't empty

		// Parse stores
		$store_count = $_POST['store-count'];
		$stores = [];
		for ($i = 1; $i <= $store_count; $i++) {
			$stores[] = [$_POST['store-type-' . $i], $_POST['store-link-' . $i]];
		}

		$R->title = $title;
		$R->url = $url;
		$R->date = strtotime($date);
		$R->label = $label;
		$R->release_type = $type;
		$R->privacy = $privacy;
		$R->setStores($stores);
		$R->save();

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
			View::redirect("/");
		}

		if ($user->verify != "0") {
			Session::init();
			Session::addFlash("bad_verify");
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

		// Check for a beta code
		$beta = Beta::get($beta_code);
		if ($beta->code == NULL) {
			Session::addFlash("nobeta");
			View::redirect("/");
		}
		$beta->delete();

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
	//	EDIT RELEASE
	//

	Route::get("/a/{username}/{url}/edit", function($username, $url) {
		Session::init();
		$user = User::getBy("username", $username);
		if ($user->id == NULL) {
			echo("No such username '" . $username . "'");
			die();
		}

		if ($user->id != Session::get("login_id")) {
			View::show("error", [
				"error" => "You don't have access to this page!"
			]);
			exit();
		}

		$R = $user->getRelease($url);

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
			echo ("No such username '" . $username . "'");
			die();
		}

		if ($user->id != Session::get("login_id")) {
			View::show("error", [
				"error" => "You don't have access to this page!"
			]);
			exit();
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
			echo ("No such username '" . $username . "'");
			die();
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
		// TODO: cleanse
		$user->name = $name;

		// Profile picture
		if ($_FILES['art']['tmp_name'] != "") {
			if ($user->profile != "profile") {
				$filename = dirname(__FILE__) . "/res/img/user_upload/" . $user->profile . ".jpg";
				unlink($filename);
			}

			$user->profile = substr(str_shuffle(md5(microtime())), 0, 32);
			$filename = dirname(__FILE__) . "/res/img/user_upload/" . $user->profile . ".jpg";
			move_uploaded_file($_FILES['art']['tmp_name'], $filename);
		}

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