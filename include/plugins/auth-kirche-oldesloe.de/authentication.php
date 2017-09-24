<?php
require_once(INCLUDE_DIR . 'class.auth.php');

class KircheOldesloeDeStaffAuthentication extends StaffAuthenticationBackend {
	static $name = 'kirche-oldesloe.de Authentication';
	static $id = 'kirche-oldesloe.de';

	function authenticate($username, $password = false, $errors = array()) {
		require_once INCLUDE_DIR . '../../api/libraries/api.php';

		$user = StaffSession::lookup($username);
		if ($user && $user->getId() && apiCheckPassword((string) $user->getEmail(), $password)) {
			return $user;
		}
		return null;
	}
}

class KircheOldesloeDeClientAuthentication extends UserAuthenticationBackend {
	static $name = 'kirche-oldesloe.de Authentication';
	static $id = 'kirche-oldesloe.de.client';

	function authenticate($username, $password = false, $errors = array()) {
		require_once INCLUDE_DIR . '../../api/libraries/api.php';

		$account = ClientAccount::lookupByUsername($username);
		if ($account && $account->getId()) {
			$client = new ClientSession(new EndUser($account->getUser()));
		}

		if (($client || strpos($username, '@') !== false) && apiCheckPassword($username, $password)) {
			if ($client) {
				return $client;
			}
			return new ClientCreateRequest($this, $username, array(
				'email' => $username,
				'name' => $username
			));
		}
		return null;
	}
}

require_once(INCLUDE_DIR . 'class.plugin.php');
require_once('config.php');

class KircheOldesloeDeAuthPlugin extends Plugin {
	var $config_class = 'KircheOldesloeDeAuthConfig';

	function bootstrap() {
		$config = $this->getConfig();
		if ($config->get('auth-staff')) {
			StaffAuthenticationBackend::register('KircheOldesloeDeStaffAuthentication');
		}
		if ($config->get('auth-client')) {
			UserAuthenticationBackend::register('KircheOldesloeDeClientAuthentication');
		}
	}
}
?>