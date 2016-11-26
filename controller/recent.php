<?php
/** 
*
* @package phpBB3
* @version $Id: recent.php,v 1.1.2 2007/08/21 23:21:39 rxu Exp $
* @copyright phpbbguru.net (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/**
* @package Recent Topics for phpBB3.1
* @author Anvar [http://bb3.mobi]
* @version v1.0.0, 2015/02/14
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace bb3mobi\recent_topics\controller;

use Symfony\Component\HttpFoundation\Response;

class recent
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request_interface */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	protected $phpbb_root_path;
	protected $php_ext;

	public function __construct(\phpbb\auth\auth $auth, \phpbb\user $user, \phpbb\config\config $config, \phpbb\request\request_interface $request, \phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, $phpbb_root_path, $php_ext)
	{
		$this->auth = $auth;
		$this->user = $user;
		$this->config = $config;
		$this->request = $request;
		$this->template = $template;
		$this->db = $db;

		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}

	public function recent()
	{
		$http_ajax = ($this->request->server('HTTP_X_REQUESTED_WITH') == "XMLHttpRequest") ? true : false;

		$crawl = $this->request->variable('mode', '');

		$this->template->assign_vars(array(
			'L_RECENT_TITLE'		=> $this->config['recent_title'],
			'L_RECENT_POSTS_NAME'	=> $this->config['recent_posts_name'],
			'S_RECENT_MARQUE'		=> ($this->config['recent_show_marque'] && $crawl) ? true: false
			)
		);

		$http_headers = array(
			// application/xhtml+xml not used because of IE
			'Content-type'	=> 'text/html; charset=UTF-8',
			'Cache-Control'	=> 'private, no-cache="set-cookie", pre-check=0, post-check=0, max-age=0',
			'Expires'		=> gmdate('D, d M Y H:i:s', time()) . ' GMT',
			'Pragma'		=> 'no-cache',
		);

		foreach ($http_headers as $hname => $hval)
		{
			header((string) $hname . ': ' . (string) $hval);
		}
		//
		// Building URL
		//
		$board_path = generate_board_url();
		$viewtopic_url = $board_path . '/viewtopic.' . $this->php_ext;

		$forum = $this->request->variable('forum', 0);

		if ($forum || (!$this->config['recent_ignore_forums'] && $this->config['recent_only_forums']))
		{
			if ($forum)
			{
				$sql_forums = ' AND t.forum_id = "' . $this->db->sql_escape($forum) . '" ';
			}
			else
			{
				$sql_forums = ' AND t.forum_id IN(' . $this->config['recent_only_forums'] .') ';
			}
		}
		else
		{
			// Fetching forums that should not be displayed
			$forums = implode(',', array_keys($this->auth->acl_getf('!f_read', true)));

			if ($this->config['recent_only_forums'] && !empty($forums))
			{
				$cfg_ignore_forums = $this->config['recent_only_forums'] . ',' . $forums;
			}
			else if (!empty($forums))
			{
				$cfg_ignore_forums = $forums;
			}
			else
			{
				$cfg_ignore_forums = ($this->config['recent_only_forums']) ? $this->config['recent_only_forums'] : '';
			}

			// Building sql for forums that should not be displayed
			$sql_forums = ($cfg_ignore_forums) ? ' AND t.forum_id NOT IN(' . $cfg_ignore_forums .') ' : '';
		}

		// Fetching topics of public forums
		$sql = 'SELECT t.*, p.post_id, p.post_text, p.bbcode_uid, p.bbcode_bitfield, p.post_attachment
			FROM ' . TOPICS_TABLE . ' AS t, ' . POSTS_TABLE . ' AS p, ' . FORUMS_TABLE . " AS f
			WHERE t.forum_id = f.forum_id
				$sql_forums
				AND p.post_id = t.topic_first_post_id
				AND t.topic_moved_id = 0
				AND t.topic_visibility = " . ITEM_APPROVED . "
			ORDER BY t.topic_last_post_id DESC";
		$result = $this->db->sql_query_limit($sql, $this->config['recent_nm_topics']);
		if (!$recent_topics = $this->db->sql_fetchrowset($result))
		{
			trigger_error('NO_FORUM');
		}
		//
		// BEGIN ATTACHMENT DATA
		//
		if ($this->config['recent_show_first_post'] && $this->config['recent_show_attachments'] && !$crawl)
		{
			$attach_list = $update_count = array();
			foreach ($recent_topics as $post_attachment)
			{
				if ($post_attachment['post_attachment'] && $this->config['allow_attachments'])
				{
					$attach_list[] = $post_attachment['post_id'];

					if ($post_attachment['topic_posts_approved'])
					{
						$has_attachments = true;
					}
				}
			}

			// Pull attachment data
			if (sizeof($attach_list))
			{
				if ($this->auth->acl_get('u_download') )
				{
					$sql_attach = 'SELECT *
						FROM ' . ATTACHMENTS_TABLE . '
						WHERE ' . $this->db->sql_in_set('post_msg_id', $attach_list) . '
							AND in_message = 0
						ORDER BY filetime DESC, post_msg_id ASC';
					$result_attach = $this->db->sql_query($sql_attach);
					while ($row_attach = $this->db->sql_fetchrow($result_attach))
					{
						$attachments[$row_attach['post_msg_id']][] = $row_attach;
					}
					$this->db->sql_freeresult($result_attach);
				}
				else
				{
					$display_notice = true;
				}
			}
		}
		//
		// END ATTACHMENT DATA
		//

		foreach ($recent_topics as $row)
		{
			$topic_title = censor_text($row['topic_title']);
			if (!$this->config['recent_show_first_post'] && utf8_strlen($topic_title) > $this->config['recent_max_topic_length'])
			{
				$topic_title = utf8_substr($topic_title, 0, $this->config['recent_max_topic_length']) . '&hellip;';
			}

			// Replies
			if ($this->config['recent_show_replies'])
			{
				global $phpbb_container;
				$phpbb_content_visibility = $phpbb_container->get('content.visibility');
				$replies = $phpbb_content_visibility->get_count('topic_posts', $row, $row['forum_id']) - 1;
			}

			$this->template->assign_block_vars('topicrow', array(
				'U_TOPIC'				=> $viewtopic_url . '?t=' . $row['topic_id'],
				'U_LAST_POST'			=> $viewtopic_url . '?p=' . $row['topic_last_post_id'] . '#' . $row['topic_last_post_id'],
				'TOPIC_TITLE'			=> $topic_title,
				'TOPIC_REPLIES'			=> (isset($replies)) ? $replies : '',
				'TOPIC_AUTHOR'			=> get_username_string('username', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
				'TOPIC_AUTHOR_COLOUR'	=> get_username_string('colour', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
				'FIRST_POST_TIME'		=> $this->user->format_date($row['topic_time']),
				'LAST_POST_TIME'		=> $this->user->format_date($row['topic_last_post_time']),
				'LAST_POST_AUTHOR'		=> get_username_string('username', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
				'POST_AUTHOR_COLOUR'	=> get_username_string('colour', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
			));

			if ($this->config['recent_show_first_post'] && !$crawl)
			{
				$message = $row['post_text'];

				if (utf8_strlen($message) > $this->config['recent_max_topic_length'])
				{
					//strip_bbcode($message);
					//$message = utf8_substr($message, 0, $this->config['recent_max_topic_length']) . '&hellip;';
					$message = $this->text_substr($message, $this->config['recent_max_topic_length']) . '&hellip;';
				}

				// Parse the message and subject
				$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
				$message = generate_text_for_display($message, $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);

				if (!$http_ajax)
				{
					$message = str_replace(array("\r\n", "\r", "\n"), ' ', $message);
					$message = addslashes($message);
					$message = $this->strip_selected_tags($message, array('dl', 'dt', 'dd'));
				}
				$message = str_replace('"./', '"' . $board_path . '/', $message);

				// Display not already displayed Attachments for this post, we already parsed them. ;)
				if ($this->config['recent_show_attachments'] && !empty($attachments[$row['post_id']]))
				{
					// Parse attachments
					parse_attachments($row['forum_id'], $message, $attachments[$row['post_id']], $update_count);
				}

				$this->template->assign_block_vars('topicrow.first_post_text', array(
					'TOPIC_FIRST_POST_TEXT'	=> $message,
					'S_HAS_ATTACHMENTS'		=> ($this->config['recent_show_attachments'] && !empty($attachments[$row['post_id']])) ? true : false,
				));

				if ($this->config['recent_show_attachments'] && !empty($attachments[$row['post_id']]))
				{
					foreach ($attachments[$row['post_id']] as $attachment)
					{
						if (!$http_ajax)
						{
							$attachment = str_replace(array("\r\n", "\r", "\n"), ' ', $attachment);
							$attachment = $this->strip_selected_tags($attachment, array('span', 'dt', 'dd'));
						}
						$attachment = str_replace('"./', '"' . $board_path . '/', $attachment);

						$this->template->assign_block_vars('topicrow.first_post_text.attachment', array(
							'DISPLAY_ATTACHMENT'	=>  $attachment)
						);
					}
				}
			}
		}
		$this->db->sql_freeresult($result);

		//
		// Load template
		//
		$this->template->set_filenames(array(
			'body' => ($http_ajax) ? '@bb3mobi_recent_topics/recent_ajax_body.html' : '@bb3mobi_recent_topics/recent_body.html')
		);

		//
		// Output
		//
		$this->template->display('body');

		garbage_collection();
		exit_handler();
	}
	/**
	* Works like PHP function strip_tags, but it only removes selected tags.
	* Example: * strip_selected_tags('<b>Person:</b> <strong>Larcher</strong>', 'strong') => <b>Person:</b> Larcher
	* by Matthieu Larcher 
	* http://ru2.php.net/manual/en/function.strip-tags.php#76045
	*/
	private function strip_selected_tags($text, $tags = array())
	{
		$args = func_get_args();
		$text = array_shift($args);
		$tags = (func_num_args() > 2) ? array_diff($args,array($text)) : (array)$tags;
		foreach ($tags as $tag)
		{
			while(preg_match('/<'.$tag.'(|\W[^>]*)>(.*)<\/'. $tag .'>/iusU', $text, $found))
			{
				$text = str_replace($found[0],$found[2],$text);
			}
		}

		return preg_replace('/(<('.join('|',$tags).')(|\W.*)\/>)/iusU', '', $text);
	}

	private function text_substr($text_str, $length)
	{
		$result = '';
		$real = 0; // позиция курсора в исходной строке
		$spec = 0; // позиция курсора в строке без учета bb-кода

		while ($spec < $length && $real < utf8_strlen($text_str))
		{
			// убираем из начальной строки уже обработанные символы
			$str = utf8_substr($text_str, $real);
			$char = utf8_substr($str, 0, 1);
			if ($char == '[')
			{
				// встретили начало bb-кода, добавляем этот код к строке-результату
				if (preg_match('/^\[[^\]]+\][^\[]*\[\/[^\]]+\]/', $str, $match))
				{
					$real += utf8_strlen($match[0]);
					$result .= $match[0];
					continue;
				}
			}

			if ($char == '<')
			{
				// встретили начало смайла, добавляем этот смайл к строке-результату
				if (preg_match('#<!\-\- s(.*?) \-\-><img src="\{SMILIES_PATH\}\/(.*?) \/><!\-\- s\1 \-\->#', $str, $match))
				{
					$real += utf8_strlen($match[0]);
					$result .= $match[0];
					continue;
				}
			}

			$result .= $char;
			$spec++;
			$real++;
		}

		return $result;
	}
}
