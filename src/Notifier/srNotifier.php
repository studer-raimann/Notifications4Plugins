<?php

namespace srag\Plugins\Notifications4Plugins\Notifier;

use ilNotifications4PluginsPlugin;
use srag\DIC\Notifications4Plugins\DICTrait;
use srag\Plugins\Notifications4Plugins\Notification\srNotification;
use srag\Plugins\Notifications4Plugins\NotificationSender\srNotificationSender;
use srag\Plugins\Notifications4Plugins\Parser\srNotificationParser;
use srag\Plugins\Notifications4Plugins\Parser\srNotificationTwigParser;
use srag\Plugins\Notifications4Plugins\Utils\Notifications4PluginsTrait;

/**
 * Class srNotifier
 *
 * Wrapper class to send notifications. You can also send notifications directly via the srNotification objects,
 * see srNotification::send() for more informations.
 *
 * @package srag\Plugins\Notifications4Plugins\Notifier
 *
 * @author  Stefan Wanzenried <sw@studer-raimann.ch>
 */
class srNotifier {

	use DICTrait;
	use Notifications4PluginsTrait;
	const PLUGIN_CLASS_NAME = ilNotifications4PluginsPlugin::class;
	/**
	 * @var srNotification
	 */
	protected $notification;
	/**
	 * @var srNotificationSender
	 */
	protected $sender;
	/**
	 * @var array
	 */
	protected $replacements = array();
	/**
	 * @var string
	 */
	protected $language = '';
	/**
	 * @var srNotificationParser
	 */
	protected $parser;


	/**
	 * srNotifier constructor
	 *
	 * @param srNotification       $notification
	 * @param srNotificationSender $sender
	 * @param string               $language     If empty, the default language of the srNotification object is used
	 * @param array                $replacements If empty, placeholders are not replaced
	 * @param srNotificationParser $parser
	 */
	public function __construct(srNotification $notification, srNotificationSender $sender, $language = '', array $replacements = array(), srNotificationParser $parser = null) {
		$this->notification = $notification;
		$this->sender = $sender;
		$this->replacements = $replacements;
		$this->language = $language;
		$this->parser = $parser ? $parser : new srNotificationTwigParser();
	}


	/**
	 * Start the notification
	 *
	 * @return bool
	 */
	public function notify() {
		// Parse the text and subject
		$text = $this->parser->parse($this->notification->getText($this->language), $this->replacements);
		$subject = $this->parser->parse($this->notification->getSubject($this->language), $this->replacements);

		// Send out the notification over the given sender object
		$this->sender->setMessage($text);
		$this->sender->setSubject($subject);

		//        var_dump($text);
		//        var_dump($subject);
		//        die();

		return $this->sender->send();
	}
}
