<?php
/**
 * Extending Piwik for the JISC Track OER project.
 *
 * @link http://track.olnet.org
 * @license
 * @copyright 2012 The Open University.
 * @author N.D.Freear, 7-22 August 2012.
 *
 * @category Piwik_Plugins
 * @package Piwik_TrackOER
 */


/**
 *
 * @package Piwik_TrackOER
 */
class Piwik_ExternalLink_Controller extends Piwik_Controller
{

	/**
	 * Output redirection page instead of linking directly to avoid
	 * exposing the referrer on the Piwik demo.
	 * @see Proxy::redirect
	 *
	 * @param string $url (via $_GET)
	 */
	public function redirect()
	{
		$url = Piwik_Common::getRequestVar('url', '', 'string', $_GET);

		if (! $url) //|| '-'==$url)
		{
			$base_url = Piwik::getPiwikUrl();
			$url = str_replace('piwik/', '', $base_url);
		}

		// validate referrer
		/*?? $referrer = Piwik_Url::getReferer();
		if(!empty($referrer)) //&& !Piwik_Url::isLocalUrl($referrer))
		{
			die('Invalid Referer detected - check that your browser sends the Referer header. <br/>The link you would have been redirected to is: '.$url .' REF: '. $referrer);
		}*/

		// mask visits to *.piwik.org
		/*if(Proxy::isPiwikUrl($url))
		{
			echo
'<html><head>
<meta http-equiv="refresh" content="0;url=' . $url . '" />
</head></html>';
		}
		else*/
		{
			Piwik_Common::sendHeader('HTTP/1.1 302 Found');
			Piwik_Common::sendHeader('Location: '. $url);
		}

		exit;
	}

	public function __redirect()
	{

        $url = Piwik_Config::getInstance()->ExternalLink['url'];
		if (! $url) {
			$base_url = Piwik::getPiwikUrl();

			$url = str_replace('piwik/', '', $base_url);
		}

		header('HTTP/1.1 302 Found');
		header('Location: '. $url);

		exit;
	}

}
