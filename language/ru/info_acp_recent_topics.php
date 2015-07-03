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

	'ACP_RECENT_TOPICS'					=> 'Последние темы JS',
	'ACP_RECENT_TOPICS_EXPLAIN'			=> 'Anvar &copy; <a href="http://bb3.mobi">BB3.Mobi</a>',
	'ACP_RECENT_TOPICS_DESCRIPTION'		=> 'Вы можете настроить вывод последних тем размещённых на форуме.',
	'ACP_RECENT_SETTINGS'				=> 'Изменение настроек',
	'ACP_RECENT_JAVASCRIPT'				=> 'Java Script для внешнего вывода',
	'ACP_RECENT_JAVASCRIPT_AJAX'		=> 'Подгрузка Ajax',
	'ACP_RECENT_JAVASCRIPT_EXPLAIN'		=> 'Вы можете вывести последние темы на сайте, который использует стороннюю CMS',

	'ACP_RECENT_IGNORE_FORUMS'			=> 'Исключить форумы',
	'ACP_RECENT_IGNORE_FORUMS_EXPLAIN'	=> 'Форумы выбранные ниже будут исключены из показа последних тем.',
	'ACP_RECENT_ONLY_FORUMS'			=> 'Выберите форум',
	'ACP_RECENT_ONLY_FORUMS_EXPLAIN'	=> 'Форумы для отображения или исключения.',

	'ACP_RECENT_NM_TOPICS'				=> 'Тем для отображения',
	'ACP_RECENT_NM_TOPICS_EXPLAIN'		=> 'Количество тем для отображения',
	'ACP_RECENT_MAX_TOPIC_LENGTH'		=> 'Символов в тексте темы',
	'ACP_RECENT_MAX_TOPIC_LENGTH_EXPLAIN'	=> 'Если выключен вывод сообщений, то будет применено к названию темы.',
	'ACP_RECENT_SHOW_REPLIES'			=> 'Отобразить счётчики',
	'ACP_RECENT_SHOW_FIRST_POST'		=> 'Выводить сообщения тем',
	'ACP_RECENT_SHOW_ATTACHMENTS'		=> 'Включить вложения в сообщениях',
	'ACP_RECENT_SHOW_HEADER'			=> 'Подключить темы в шапке форума',
	'ACP_RECENT_SHOW_MARQUE'			=> 'Сделать бегущей строкой',
	'ACP_RECENT_SHOW_MARQUE_EXPLAIN'	=> 'Текст сообщения, вложения и количество ответов будут проигнорированы.<br />Необходимо установить расширение: "Rotation for blocks"',

	'ACP_RECENT_TITLE'				=> 'Название блока',
	'ACP_RECENT_TITLE_EXPLAIN'		=> 'Вы можете заменить стандартное название "Активные темы"<br />например: "Объявления"',
	'ACP_RECENT_POSTS_NAME'			=> 'Счётчик сообщений',
	'ACP_RECENT_POSTS_NAME_EXPLAIN'	=> 'Вы можете заменить стандартное название "Сообщения" перед счётчиком',
));
