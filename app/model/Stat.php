<?php

class Stat {

	// GENERIC CLICKS
	const CLICKS = 0;

	// BROWSERS
	const BROWSER_START = 0;
	const CHROME = 1;
	const FIREFOX = 2;
	const OPERA = 3;
	const SAFARI = 4;
	const EDGE = 5;
	const OTHER_BROWSER = 6;

	// OS
	const OS_START = 6;
	const WINDOWS = 7;
	const MAC = 8;
	const LINUX = 9;
	const IOS = 10;
	const ANDROID = 11;
	const OTHER_OS = 12;

	// PLATFORMS
	const PLATFORM_START = 12;
	const DESKTOP = 13;
	const MOBILE = 14;
	const OTHER_PLATFORM = 15;

	// STORES
	const STORE_START = 15;
	const SPOTIFY = 16;
	const APPLE = 17;
	const ITUNES = 18;
	const SCLOUD = 19;
	const YOUTUBE = 20;
	const DEEZER = 21;
	const AMAZON = 22;
	const GPLAY = 23;

	// ARRAY SIZE
	const STATS_ARRAY_SIZE = 24;

	function getStore($id) {
		switch ($id) {
			case Stat::SPOTIFY:
				return "Spotify";
			case Stat::APPLE:
				return "Apple Music";
			case Stat::ITUNES:
				return "iTunes";
			case Stat::SCLOUD:
				return "SoundCloud";
			case Stat::YOUTUBE:
				return "YouTube";
			case Stat::DEEZER:
				return "Deezer";
			case Stat::AMAZON:
				return "Amazon";
			case Stat::GPLAY:
				return "Google Play";
			default:
				return "???";
		}
	}

	function getBrowser($id) {
		switch ($id) {
			case Stat::CHROME:
				return "Chrome";
			case Stat::FIREFOX:
				return "Firefox";
			case Stat::OPERA:
				return "Opera";
			case Stat::SAFARI:
				return "Safari";
			case Stat::EDGE:
				return "Edge";
			case Stat::OTHER_BROWSER:
				return "Other";
		}
	}

	function getOS($id) {
		switch ($id) {
			case Stat::WINDOWS:
				return "Windows";
			case Stat::MAC:
				return "Mac";
			case Stat::LINUX:
				return "Linux";
			case Stat::IOS:
				return "iOS";
			case Stat::ANDROID:
				return "Android";
			case Stat::OTHER_OS:
				return "Other";
		}
	}

	function getPlatform($id) {
		switch ($id) {
			case Stat::DESKTOP:
				return "Desktop";
			case Stat::MOBILE:
				return "Mobile";
			case Stat::OTHER_PLATFORM:
				return "Other";
		}
	}

}

?>