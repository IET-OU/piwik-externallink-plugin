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
links["http://track.olnet.org"] = "Project Home"
links["http://blog.olnet.org"] = "Blog"


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
			#'__description' => Piwik_Translate('ExternalLink_PluginDescription'),
			'homepage' => 'http://track.olnet.org/',
			'author' => 'IET at The Open University',
			'author_homepage' => 'http://iet.open.ac.uk/',
			'version' => '0.1',
			#'translationAvailable' => true,
		);
	}

	public function getListHooksRegistered()
	{
		return array(
			'TopMenu.add' => 'addTopMenu',
			'AssetManager.getCssFiles' => 'getCssFiles',
		);
	}


	public function addTopMenu()
	{
		$links = $this->getConfigLinks();

		foreach ($links as $url => $label)
		{
			Piwik_AddTopMenu($label,
				array('module' => 'ExternalLink', 'action' => 'redirect',
					'url' => $url),
						Piwik::isUserHasSomeViewAccess(),
						$order = 6,
						$isHTML = false,
						$tooltip = false
			);
		}
	}


	/**
	 * Piwik CSS cache: tmp/assets/asset_manager_global_css
	 *
	 * @param Piwik_Event_Notification $notification  notification object
	 */
	public function getCssFiles( $notification )
	{
		$cssFiles = &$notification->getNotificationObject();

		$cssFiles[] = "plugins/ExternalLink/templates/ExternalLink.css";
	}


	protected function getConfigLinks()
	{
		$config = Piwik_Config::getInstance()->ExternalLink;
		if (isset($config['links']))
		{
			return $config['links'];
		}
		return array();
	}
}
