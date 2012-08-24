<?php
/**
 * Extending Piwik for the JISC Track OER project.
 * 
 * @link http://track.olnet.org
 * @license
 * @copyright 2012 The Open University.
 * @author N.D.Freear, 22 August 2012.
 *
 * @category Piwik_Plugins
 * @package Piwik_TrackOER
 */

/*
 Example plugin configuration -- config/config.ini.php

[ExternalLink]
label = "Track OER Home"
url = "http://track.olnet.org"

*/

/**
 *
 * @package Piwik_TrackOER
 */
class Piwik_ExternalLink extends Piwik_Plugin
{
	public function getInformation()
	{
		return array(
			'description' =>
			'* Add a link to the Piwik site top menu, pointing to an external site [JISC Track OER project]',
			#Piwik_Translate('CoreAdminHome_PluginDescription'),
			'homepage' => 'http://track.olnet.org/',
			'author' => 'IET at The Open University',
			'author_homepage' => 'http://iet.open.ac.uk/',
			'version' => '0.1',
		);
	}

	public function getListHooksRegistered()
	{
		return array(
			'TopMenu.add' => 'addTopMenu',
			#'AdminMenu.add' => 'addMenu',
			'AssetManager.getCssFiles' => 'getCssFiles',
		);
	}


	public function addTopMenu()
	{
		$label = Piwik_Config::getInstance()->ExternalLink['label'];
		//if (! $label) $label = 'Home';

		//try {
		$url = Piwik_Config::getInstance()->ExternalLink['url'];
		/*} catch($e) {
		var_dump($e);
		echo 'Exception..'
		$url = '';
		}*/

		Piwik_AddTopMenu($label,
			array('module' => 'ExternalLink', 'action' => 'redirect',
				'url' => $url),
						Piwik::isUserHasSomeViewAccess(),
						$order = 6,
						$isHTML = false,
						$tooltip = false
			);
	}


	/**
	 * Piwik CSS cache: tmp/assets/asset_manager_global_css
	 *
	 * @param Piwik_Event_Notification $notification  notification object
	 */
	function getCssFiles( $notification )
	{
		$cssFiles = &$notification->getNotificationObject();

		$cssFiles[] = "plugins/ExternalLink/templates/ExternalLink.css";
	}

}
