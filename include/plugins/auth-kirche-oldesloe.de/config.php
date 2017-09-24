<?php
require_once(INCLUDE_DIR.'/class.forms.php');

class KircheOldesloeDeAuthConfig extends PluginConfig {

	function getOptions() {
		list($__, $_N) = Plugin::translate('auth-kirche-oldesloe.de');

		return array(
			'auth' => new SectionBreakField(array(
				'label' => $__('Authentication Modes'),
				'hint' => $__('Authentication modes for clients and staff members can be enabled independently. Client discovery can be supported via a separate backend.')
			)),
			'auth-staff' => new BooleanField(array(
				'label' => $__('Staff Authentication'),
				'default' => true,
				'configuration' => array(
					'desc' => $__('Enable authentication of staff members')
				)
			)),
			'auth-client' => new BooleanField(array(
				'label' => $__('Client Authentication'),
				'default' => true,
				'configuration' => array(
					'desc' => $__('Enable authentication and discovery of clients')
				)
			))
		);
	}

	function pre_save(&$config, &$errors) {
		global $msg;
		list($__, $_N) = Plugin::translate('auth-kirche-oldesloe.de');

		if (!$errors) {
			$msg = $__('Configuration updated successfully');
		}
		return true;
	}
}
?>