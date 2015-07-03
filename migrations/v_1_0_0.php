<?php
/**
* @package phpBB3.1 Recent Topics Extension
* @copyright Anvar Apwa.ru (c) 2015 bb3.mobi
*/

namespace bb3mobi\recent_topics\migrations;

class v_1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['recent_topics_version']) && version_compare($this->config['recent_topics_version'], '1.0.0', '>=');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('recent_ignore_forums', '0')),
			array('config.add', array('recent_only_forums', '')),
			array('config.add', array('recent_nm_topics', '15')),
			array('config.add', array('recent_max_topic_length', '120')),
			array('config.add', array('recent_show_replies', '1')),
			array('config.add', array('recent_show_first_post', '1')),
			array('config.add', array('recent_show_attachments', '1')),
			array('config.add', array('recent_show_header', '1')),
			array('config.add', array('recent_show_marque', '0')),
			// Current version
			array('config.add', array('recent_topics_version', '1.0.0')),

			// Add ACP modules
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_RECENT_TOPICS')),

			array('module.add', array('acp', 'ACP_RECENT_TOPICS', array(
				'module_basename'	=> '\bb3mobi\recent_topics\acp\recent_module',
				'module_langname'	=> 'ACP_RECENT_SETTINGS',
				'module_mode'		=> 'config',
				'module_auth'		=> 'ext_bb3mobi/recent_topics',
			))),
		);
	}
}
