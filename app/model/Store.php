<?php

class Store {

	const SPOTIFY = 1;
	const APPLE = 2;
	const ITUNES = 3;
	const SOUNDCLOUD = 4;
	const YOUTUBE = 5;
	const DEEZER = 6;
	const AMAZON = 7;
	const GPLAY = 8;
	const BANDCAMP = 9;

	public static function validURL($store, $url) {
		switch ($store) {
			case Store::SPOTIFY: {
				$reg = "/^https:\/\/(.+\.)?spotify\.com\/.+$/";
				break;
			}
			case Store::APPLE: {
				$reg = "/^https:\/\/itunes\.apple\.com\/.+$/";
				break;
			}
			case Store::ITUNES: {
				$reg = "/^https:\/\/(.+\.)?itunes\.apple\.com\/.+$/";
				break;
			}
			case Store::SOUNDCLOUD: {
				$reg = "/^https:\/\/(.+\.)?soundcloud\.com\/.+$/";
				break;
			}
			case Store::YOUTUBE: {
				$reg = "/^https:\/\/(.+\.)?(youtube\.com|youtu\.be)\/.+$/";
				break;
			}
			case Store::DEEZER: {
				$reg = "/^https:\/\/(.+\.)?deezer\.com\/.+$/";
				break;
			}
			case Store::AMAZON: {
				$reg = "/^https:\/\/(.+\.)?amazon\.com\/.+$/";
				break;
			}
			case Store::GPLAY: {
				$reg = "/^https:\/\/(.+\.)?play.google.com\/.+$/";
				break;
			}
			case Store::BANDCAMP: {
				$reg = "/^https:\/\/(.+).bandcamp.com\/.+$/";
				break;
			}
			case 0: {
				return 0;
			}
		}

		return preg_match($reg, $url);
	}

}

?>