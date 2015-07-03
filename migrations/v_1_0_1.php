<?php
/**
* @package phpBB3.1 Recent Topics Extension
* @copyright Anvar Apwa.ru (c) 2015 bb3.mobi
*/

namespace bb3mobi\recent_topics\migrations;

class v_1_0_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['recent_topics_version']) && version_compare($this->config['recent_topics_version'], '1.0.1', '>=');
	}

	static public function depends_on()
	{
		return array('\bb3mobi\recent_topics\migrations\v_1_0_0');
	}

	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('recent_title', '')),
			array('config.add', array('recent_posts_name', '')),

			// Current version
			array('config.update', array('recent_topics_version', '1.0.1')),
		);
	}
}
