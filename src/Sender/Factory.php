<?php

namespace srag\Plugins\Notifications4Plugins\Sender;

use ilNotifications4PluginsPlugin;
use ilObjUser;
use srag\DIC\Notifications4Plugins\DICTrait;
use srag\Plugins\Notifications4Plugins\Utils\Notifications4PluginsTrait;

/**
 * Class Factory
 *
 * @package srag\Plugins\Notifications4Plugins\Sender
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Factory {

	use DICTrait;
	use Notifications4PluginsTrait;
	const PLUGIN_CLASS_NAME = ilNotifications4PluginsPlugin::class;
	/**
	 * @var self
	 */
	protected static $instance = null;


	/**
	 * @return self
	 */
	public static function getInstance()/*: self*/ {
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Factory constructor
	 */
	private function __construct() {

	}


	/**
	 * @param string|array $to
	 * @param string       $from
	 *
	 * @return ExternalMailSender
	 */
	public function externalMail($to = "", /*string*/
		$from = "")/*: ExternalMailSender*/ {
		return new ExternalMailSender($to, $from);
	}


	/**
	 * @param int|string|ilObjUser $user_from
	 * @param int|string|ilObjUser $user_to
	 *
	 * @return InternalMailSender
	 */
	public function internalMail($user_from = 0, $user_to = "")/*: InternalMailSender*/ {
		return new InternalMailSender($user_from, $user_to);
	}


	/**
	 * @param string|array         $to
	 * @param int|string|ilObjUser $user_from
	 * @param string               $method
	 * @param string               $uid
	 * @param int                  $startTime
	 * @param int                  $endTime
	 * @param int                  $sequence
	 *
	 * @return vcalendarSender
	 */
	public function vcalendar($to = "", $user_from = 0, /*string*/
		$method = vcalendarSender::METHOD_REQUEST, /*string*/
		$uid = "", /*int*/
		$startTime = 0, /*int*/
		$endTime = 0, /*int*/
		$sequence = 0)/*: vcalendarSender*/ {
		return new vcalendarSender($to, $user_from, $method, $uid, $startTime, $endTime, $sequence);
	}
}