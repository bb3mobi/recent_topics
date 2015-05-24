<?php
/**
* @package Recent Topics for phpBB3.1
* @author Anvar [http://bb3.mobi]
* @version v1.0.0, 2015/02/14
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace bb3mobi\recent_topics\acp;

class recent_info
{
	function module()
	{
		return array(
			'filename'	=> '\bb3mobi\recetn_topics\acp\recent_module',
			'title'		=> 'ACP_RECENT_TOPICS_TITLE',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'config'		=> array('title' => 'ACP_RECENT_TOPICS', 'auth' => 'ext_bb3mobi/recent_topics', 'cat' => array('ACP_RECENT_TOPICS_TITLE')),
			),
		);
	}
}
