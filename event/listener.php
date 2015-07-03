<?php

/**
* @package Recent Topics for phpBB3.1
* @author Anvar [http://bb3.mobi]
* @version v1.0.0, 2015/02/14
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace bb3mobi\recent_topics\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\controller\helper */
	protected $helper;

	public function __construct(\phpbb\config\config $config, \phpbb\template\template $template, \phpbb\controller\helper $helper)
	{
		$this->config = $config;
		$this->template = $template;
		$this->helper = $helper;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header_after' => 'recent_topics',
		);
	}

	public function recent_topics()
	{
		$this->template->assign_vars(array(
			'U_RECENT_TOPICS'	=> $this->helper->route("bb3mobi_recent_topics_controller", array(), false, '', true),
			'U_RECENT_CRAWL'	=> $this->helper->route("bb3mobi_recent_topics_controller", array('mode' => 'crawl'), false, '', true),
			'S_RECENT_TOPICS'	=> $this->config['recent_show_header'],
			'S_RECENT_MARQUE'	=> $this->config['recent_show_marque'],
			)
		);
	}
}
