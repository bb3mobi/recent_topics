<?php
/**
* @package Recent Topics for phpBB3.1
* @author Anvar [http://bb3.mobi]
* @version v1.0.0, 2015/02/14
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_RECENT_TOPICS_TITLE'			=> 'Recent topics for JS',

	'ACP_RECENT_TOPICS'					=> 'Recent topics JS',
	'ACP_RECENT_TOPICS_EXPLAIN'			=> 'Anvar &copy; <a href="http://bb3.mobi">BB3.Mobi</a>',
	'ACP_RECENT_TOPICS_DESCRIPTION'		=> 'You can set output to last topics in forums.',
	'ACP_RECENT_SETTINGS'				=> 'Change settings',
	'ACP_RECENT_JAVASCRIPT'				=> 'Java Script for external output',
	'ACP_RECENT_JAVASCRIPT_AJAX'		=> 'Java Script Ajax',
	'ACP_RECENT_JAVASCRIPT_EXPLAIN'		=> 'You can display the latest topics on a site that uses a third-party CMS',

	'ACP_RECENT_IGNORE_FORUMS'			=> 'Ignore forums',
	'ACP_RECENT_IGNORE_FORUMS_EXPLAIN'	=> 'Forums chosen below will be excluded from the last show.',
	'ACP_RECENT_ONLY_FORUMS'			=> 'Select a forum',
	'ACP_RECENT_ONLY_FORUMS_EXPLAIN'	=> 'Forums to display or exclusion.',

	'ACP_RECENT_NM_TOPICS'				=> 'Topics to display',
	'ACP_RECENT_NM_TOPICS_EXPLAIN'		=> 'Number of topics to display',
	'ACP_RECENT_MAX_TOPIC_LENGTH'		=> 'Max characters in text topics',
	'ACP_RECENT_MAX_TOPIC_LENGTH_EXPLAIN'	=> 'If you turn off output messages, it will be applied to name of topics.',
	'ACP_RECENT_SHOW_REPLIES'			=> 'Display count posts',
	'ACP_RECENT_SHOW_FIRST_POST'		=> 'Show first posts',
	'ACP_RECENT_SHOW_ATTACHMENTS'		=> 'Enable attachments in posts',
	'ACP_RECENT_SHOW_HEADER'			=> 'Connect the threads in header Forum',
	'ACP_RECENT_SHOW_MARQUE'			=> 'Make crawl',
	'ACP_RECENT_SHOW_MARQUE_EXPLAIN'	=> 'Text messages, attachments, and the number of responses will be ignored.<br />Should be install extension: "Rotation for blocks"',

	'ACP_RECENT_TITLE'				=> 'Name of block',
	'ACP_RECENT_TITLE_EXPLAIN'		=> 'You can replace the default name "Active topics"<br />example: "Announcements"',
	'ACP_RECENT_POSTS_NAME'			=> 'Name Posts',
	'ACP_RECENT_POSTS_NAME_EXPLAIN'	=> 'You can replace the default name "messages" to counter',
));
