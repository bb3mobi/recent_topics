<?php
/**
* @package Recent Topics for phpBB3.1
* @author Anvar [http://bb3.mobi]
* @version v1.0.0, 2015/02/14
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace bb3mobi\recent_topics\acp;

class recent_module
{
	var $u_action;
	var $new_config = array();

	function main($id, $mode)
	{
		global $config, $user, $template, $request, $phpbb_container;

		$controller = $phpbb_container->get('bb3mobi.recent_topics.listener');
		$controller->recent_topics();

		$this->page_title = 'ACP_RECENT_TOPICS_TITLE';
		$this->tpl_name = 'acp_recent_topics';

		$submit = $request->is_set_post('submit');

		$form_key = 'config';
		add_form_key($form_key);

		$display_vars = array(
			'title'	=> 'ACP_RECENT_TOPICS',
			'vars'	=> array(
				'legend1'	=> 'ACP_RECENT_SETTINGS',
					'recent_ignore_forums'		=> array('lang' => 'ACP_RECENT_IGNORE_FORUMS',		'validate' => 'bool',		'type' => 'radio:yes_no', 'explain' => true),
					'recent_only_forums'		=> array('lang' => 'ACP_RECENT_ONLY_FORUMS',		'validate' => 'string',		'type' => 'custom', 'method' => 'select_forums', 'explain' => true),
					'recent_nm_topics'			=> array('lang' => 'ACP_RECENT_NM_TOPICS',			'validate' => 'int:1:30',	'type' => 'number:1:30', 'explain' => true),
					'recent_show_replies'		=> array('lang' => 'ACP_RECENT_SHOW_REPLIES',		'validate' => 'bool',		'type' => 'radio:yes_no', 'explain' => false),
					'recent_max_topic_length'	=> array('lang' => 'ACP_RECENT_MAX_TOPIC_LENGTH',	'validate' => 'int:10:1999',	'type' => 'number:10:1999', 'explain' => true),
					'recent_show_first_post'	=> array('lang' => 'ACP_RECENT_SHOW_FIRST_POST',	'validate' => 'bool',		'type' => 'radio:yes_no', 'explain' => false),
					'recent_show_attachments'	=> array('lang' => 'ACP_RECENT_SHOW_ATTACHMENTS',	'validate' => 'bool',		'type' => 'radio:yes_no', 'explain' => false),
					'recent_show_header'		=> array('lang' => 'ACP_RECENT_SHOW_HEADER',		'validate' => 'bool',		'type' => 'radio:yes_no', 'explain' => false),
					'recent_show_marque'		=> array('lang' => 'ACP_RECENT_SHOW_MARQUE',		'validate' => 'bool',		'type' => 'radio:yes_no', 'explain' => true),
					'recent_title'				=> array('lang' => 'ACP_RECENT_TITLE',				'validate' => 'string',		'type' => 'text:20:40', 'explain' => true),
					'recent_posts_name'			=> array('lang' => 'ACP_RECENT_POSTS_NAME',			'validate' => 'string',		'type' => 'text:20:40', 'explain' => true),
				'legend2'	=> 'ACP_SUBMIT_CHANGES',
			),
		);

		if (isset($display_vars['lang']))
		{
			$user->add_lang($display_vars['lang']);
		}

		$this->new_config = $config;

		$cfg_array = ($request->is_set('config')) ? utf8_normalize_nfc($request->variable('config', array('' => ''), true)) : $this->new_config;
		$error = array();

		// We validate the complete config if wished
		validate_config_vars($display_vars['vars'], $cfg_array, $error);

		if ($submit && !check_form_key($form_key))
		{
			$error[] = $user->lang['FORM_INVALID'];
		}
		// Do not write values if there is an error
		if (sizeof($error))
		{
			$submit = false;
		}

		// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
		foreach ($display_vars['vars'] as $config_name => $null)
		{
			if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}

			$this->new_config[$config_name] = $config_value = $cfg_array[$config_name];

			if ($submit)
			{
				$config->set($config_name, $config_value);
			}
		}

		if ($submit)
		{
			// POST Forums config && Anvar (bb3.mobi)
			$values = request_var('recent_only_forums', array(0 => ''));
			$news = implode(',', $values);
			$config->set('recent_only_forums', $news);

			trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
		}

		$this->page_title = $display_vars['title'];

		$template->assign_vars(array(
			'L_TITLE'				=> $user->lang[$display_vars['title']],
			'L_TITLE_EXPLAIN'		=> $user->lang[$display_vars['title'] . '_EXPLAIN'],
			'L_TITLE_DESCRIPTION'	=> $user->lang[$display_vars['title'] . '_DESCRIPTION'],

			'S_ERROR'			=> (sizeof($error)) ? true : false,
			'ERROR_MSG'			=> implode('<br />', $error),
		));

		// Output relevant page
		foreach ($display_vars['vars'] as $config_key => $vars)
		{
			if (!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if (strpos($config_key, 'legend') !== false)
			{
				$template->assign_block_vars('options', array(
					'S_LEGEND'		=> true,
					'LEGEND'		=> (isset($user->lang[$vars])) ? $user->lang[$vars] : $vars)
				);

				continue;
			}

			$type = explode(':', $vars['type']);

			$l_explain = '';
			if ($vars['explain'] && isset($vars['lang_explain']))
			{
				$l_explain = (isset($user->lang[$vars['lang_explain']])) ? $user->lang[$vars['lang_explain']] : $vars['lang_explain'];
			}
			else if ($vars['explain'])
			{
				$l_explain = (isset($user->lang[$vars['lang'] . '_EXPLAIN'])) ? $user->lang[$vars['lang'] . '_EXPLAIN'] : '';
			}

			$l_description = (isset($user->lang[$vars['lang'] . '_DESCRIPTION'])) ? $user->lang[$vars['lang'] . '_DESCRIPTION'] : '';

			$content = build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);

			if (empty($content))
			{
				continue;
			}

			$template->assign_block_vars('options', array(
				'KEY'					=> $config_key,
				'TITLE'					=> (isset($user->lang[$vars['lang']])) ? $user->lang[$vars['lang']] : $vars['lang'],
				'S_EXPLAIN'				=> $vars['explain'],
				'TITLE_EXPLAIN'			=> $l_explain,
				'TITLE_DESCRIPTION'		=> $l_description,
				'CONTENT'				=> $content,
				)
			);

			unset($display_vars['vars'][$config_key]);
		}
	}

	function select_forums($value, $key)
	{// Select Forums function && Anvar (bb3.mobi)
		global $user, $config;

		$forum_list = make_forum_select(false, false, true, true, true, false, true);

		$selected = array();
		if(isset($config[$key]) && strlen($config[$key]) > 0)
		{
			$selected = explode(',', $config[$key]);
		}
		// Build forum options
		$s_forum_options = '<select id="' . $key . '" name="' . $key . '[]" multiple="multiple">';
		foreach ($forum_list as $f_id => $f_row)
		{
			$s_forum_options .= '<option value="' . $f_id . '"' . ((in_array($f_id, $selected)) ? ' selected="selected"' : '') . (($f_row['disabled']) ? ' disabled="disabled" class="disabled-option"' : '') . '>' . $f_row['padding'] . $f_row['forum_name'] . '</option>';
		}
		$s_forum_options .= '</select>';

		return $s_forum_options;
	}
}
