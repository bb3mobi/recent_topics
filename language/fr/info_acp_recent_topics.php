<?php
/**
*
* Recent Topics for JS extension for the phpBB Forum Software package.
* French translation by Galixte (http://www.galixte.com)
*
* @copyright (c) 2015 Anvar <http://bb3.mobi>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'ACP_RECENT_TOPICS_TITLE'			=> 'Sujets actifs JS',

	'ACP_RECENT_TOPICS'					=> 'Sujets actifs JS',
	'ACP_RECENT_TOPICS_EXPLAIN'			=> 'Anvar &copy; <a href="http://bb3.mobi">BB3.Mobi</a>',
	'ACP_RECENT_TOPICS_DESCRIPTION'		=> 'Configuration de l’affichage des derniers sujets publiés dans les forums.',
	'ACP_RECENT_SETTINGS'				=> 'Modifier les paramètres',
	'ACP_RECENT_JAVASCRIPT'				=> 'Java Script pour un affichage externe au forum',
	'ACP_RECENT_JAVASCRIPT_AJAX'		=> 'Java Script Ajax',
	'ACP_RECENT_JAVASCRIPT_EXPLAIN'		=> 'Permet d’afficher les derniers sujets sur un site externe, tel un CMS.',

	'ACP_RECENT_IGNORE_FORUMS'			=> 'Ignorer des forums',
	'ACP_RECENT_IGNORE_FORUMS_EXPLAIN'	=> 'Permet d’ignorer les forums sélectionnés ci-dessous de l’affichage des sujets.',
	'ACP_RECENT_ONLY_FORUMS'			=> 'Sélectionner un ou plusieurs forums',
	'ACP_RECENT_ONLY_FORUMS_EXPLAIN'	=> 'Si l’option « Ignorer des forums » est activée, la sélection permet de choisir les forums à ignorer de l’affichage. Si la même option est désactivée, la sélection permet de choisir les forums sources de l’affichage.<br />Pour sélectionner plusieurs forums, merci d’utiliser la combinaison de la touche CTRL et du clic gauche de la souris.',

	'ACP_RECENT_NM_TOPICS'				=> 'Sujets à afficher',
	'ACP_RECENT_NM_TOPICS_EXPLAIN'		=> 'Nombre de sujets à afficher.',
	'ACP_RECENT_MAX_TOPIC_LENGTH'		=> 'Nombre de caractères pour les sujets',
	'ACP_RECENT_MAX_TOPIC_LENGTH_EXPLAIN'	=> 'Permet de saisir le nombre maximum de caractères à afficher. Si l’option « Afficher le contenu du premier message des sujets » est activée, cela permet de choisir le nombre de caractères du premier message, auquel cas contraire cela permet de choisir le nombre de caractères du titre du sujet.',
	'ACP_RECENT_SHOW_REPLIES'			=> 'Afficher le nombre de réponses des sujets',
	'ACP_RECENT_SHOW_FIRST_POST'		=> 'Afficher le contenu du premier message des sujets',
	'ACP_RECENT_SHOW_ATTACHMENTS'		=> 'Afficher les fichiers joints du premier message des sujets',
	'ACP_RECENT_SHOW_HEADER'			=> 'Activer l’affichage des sujets actifs en haut du forum',
	'ACP_RECENT_SHOW_MARQUE'			=> 'Activer l’affichage par défilement des titres des sujets',
	'ACP_RECENT_SHOW_MARQUE_EXPLAIN'	=> 'Si activé, l’affichage du contenu du premier message, des fichiers joints ainsi que du nombre de réponses sont désactivés, en lieu et place un défilement des titres des sujets est affiché.<br />L’extension suivante est nécessaire pour cette option : « <a href="http://bb3.mobi/forum/viewtopic.php?t=184">Rotation for blocks</a> ».',

	'ACP_RECENT_TITLE'				=> 'Nom du bloc',
	'ACP_RECENT_TITLE_EXPLAIN'		=> 'Permet de remplacer le nom par défaut du bloc, par exemple : « Sujets actifs ».',
	'ACP_RECENT_POSTS_NAME'			=> 'Terme pour les réponses',
	'ACP_RECENT_POSTS_NAME_EXPLAIN'	=> 'Permet de remplacer le terme par défaut accompagnant le nombre affiché des réponses, par exemple : « Réponses apportées : ».',
));
