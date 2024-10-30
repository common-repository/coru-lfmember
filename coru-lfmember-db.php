<?php
#################################################################################
#	Copyright 2010  Marco Rülicke  (email : marcoruelicke@gmail.com)			#
#																				#
#	This program is free software; you can redistribute it and/or modify		#
#	it under the terms of the GNU General Public License, version 2, as 		#
#	published by the Free Software Foundation.									#
#																				#
#	This program is distributed in the hope that it will be useful,				#
#	but WITHOUT ANY WARRANTY; without even the implied warranty of				#
#	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the				#
#	GNU General Public License for more details.								#
#																				#
#	You should have received a copy of the GNU General Public License			#
#	along with this program; if not, write to the Free Software					#
#	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA	#
#################################################################################

function coru_lfmember_db_install()
{
	global $wpdb;
	$default_link = get_option('home');
	
	$coru_lfmember_game = $wpdb->prefix . "coru_lfmember_game";
	$coru_lfmember_list = $wpdb->prefix . "coru_lfmember_list";
	
	$install_verify = 0;
	
	if($wpdb->get_var("SHOW TABLES LIKE '$coru_lfmember_game'") != $coru_lfmember_game)
	{
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$sql = "CREATE TABLE " . $coru_lfmember_game . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				game_description mediumtext NOT NULL,
				game_enabled tinyint(1) DEFAULT '0' NOT NULL,
				game_image VARCHAR(255) NOT NULL,
				game_link VARCHAR(255) NOT NULL,
				game_name_long tinytext NOT NULL,
				game_name_short tinytext NOT NULL,
				UNIQUE KEY id (id)
			);";
		dbDelta($sql);
		
		$wpdb->insert( $coru_lfmember_game , array(
													'id'				=> NULL,
													'game_description'	=> 'World of Warcraft, often referred to as WoW, is a massively multiplayer online role-playing game (MMORPG) by Blizzard Entertainment.<br />With more than 11.5 million monthly subscriptions in December 2008, World of Warcraft is currently the world\'s most-subscribed MMORPG, and holds the Guinness World Record for the most popular MMORPG by subscribers.',
													'game_enabled'		=> '1',
													'game_image'		=> 'icon-wow.png',
													'game_link'			=> $default_link,
													'game_name_long'	=> 'World of Warcraft',
													'game_name_short'	=> 'WoW',
												));
		$install_verify++;
	}
	
	if($wpdb->get_var("SHOW TABLES LIKE '$coru_lfmember_list'") != $coru_lfmember_list)
	{
		$sql = "CREATE TABLE " . $coru_lfmember_list . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				game_id mediumint(9) DEFAULT '0' NOT NULL,
				position_detail tinytext NOT NULL,
				position_image VARCHAR(255) NOT NULL,
				position_link VARCHAR(255) NOT NULL,
				position_name tinytext NOT NULL,
				position_need mediumint(9) DEFAULT '0' NOT NULL,
				position_open tinyint(1) DEFAULT '0' NOT NULL,
				UNIQUE KEY id (id)
			);";
		dbDelta($sql);
		
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> ' ',
													'position_image'	=> 'icon-deathknight.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Deathknight',
													'position_need'		=> '1',
													'position_open'		=> '1'
													)
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Blood',
													'position_image'	=> 'icon-deathknight.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Deathknight',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Frost',
													'position_image'	=> 'icon-deathknight.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Deathknight',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Unholy',
													'position_image'	=> 'icon-deathknight.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Deathknight',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> ' ',
													'position_image'	=> 'icon-druid.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Druid',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Balance',
													'position_image'	=> 'icon-druid.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Druid',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Feral (DPS)',
													'position_image'	=> 'icon-druid.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Druid',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Feral (Tank)',
													'position_image'	=> 'icon-druid.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Druid',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Restoration',
													'position_image'	=> 'icon-druid.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Druid',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> ' ',
													'position_image'	=> 'icon-hunter.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Hunter',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Beastmaster',
													'position_image'	=> 'icon-hunter.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Hunter',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Marksman',
													'position_image'	=> 'icon-hunter.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Hunter',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Survival',
													'position_image'	=> 'icon-hunter.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Hunter',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> ' ',
													'position_image'	=> 'icon-mage.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Mage',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Arcane',
													'position_image'	=> 'icon-mage.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Mage',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Fire',
													'position_image'	=> 'icon-mage.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Mage',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Frost',
													'position_image'	=> 'icon-mage.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Mage',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> ' ',
													'position_image'	=> 'icon-paladin.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Paladin',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Holy',
													'position_image'	=> 'icon-paladin.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Paladin',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Protection',
													'position_image'	=> 'icon-paladin.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Paladin',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Retribution',
													'position_image'	=> 'icon-paladin.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Paladin',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> ' ',
													'position_image'	=> 'icon-priest.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Priest',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Discipline',
													'position_image'	=> 'icon-priest.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Priest',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Holy',
													'position_image'	=> 'icon-priest.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Priest',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Shadow',
													'position_image'	=> 'icon-priest.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Priest',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> ' ',
													'position_image'	=> 'icon-rogue.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Rogue',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Assassination',
													'position_image'	=> 'icon-rogue.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Rogue',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Combat',
													'position_image'	=> 'icon-rogue.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Rogue',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Subtlety',
													'position_image'	=> 'icon-rogue.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Rogue',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> ' ',
													'position_image'	=> 'icon-shaman.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Shaman',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Elemental',
													'position_image'	=> 'icon-shaman.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Shaman',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Enhancement',
													'position_image'	=> 'icon-shaman.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Shaman',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Restoration',
													'position_image'	=> 'icon-shaman.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Shaman',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> ' ',
													'position_image'	=> 'icon-warlock.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Warlock',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Affliction',
													'position_image'	=> 'icon-warlock.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Warlock',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Demonology',
													'position_image'	=> 'icon-warlock.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Warlock',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Destruction',
													'position_image'	=> 'icon-warlock.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Warlock',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> ' ',
													'position_image'	=> 'icon-warrior.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Warrior',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Arms',
													'position_image'	=> 'icon-warrior.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Warrior',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Fury',
													'position_image'	=> 'icon-warrior.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Warrior',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$wpdb->insert( $coru_lfmember_list ,  array(
													'id'				=> NULL ,
													'game_id'			=> '1',
													'position_detail'	=> 'Protection',
													'position_image'	=> 'icon-warrior.png',
													'position_link'		=> $default_link,
													'position_name'		=> 'Warrior',
													'position_need'		=> '1',
													'position_open'		=> '1')
												);
		$install_verify++;
	}
	
	if($install_verify==2)
	{
		update_option("coru_lfmember_version","1.0");
	}
}

function coru_lfmember_db_uninstall()
{
	global $wpdb;
	
	$wpdb->query('DROP TABLE ' . $wpdb->prefix . 'coru_lfmember_game');
	$wpdb->query('DROP TABLE ' . $wpdb->prefix . 'coru_lfmember_list');
	
	delete_option("coru_lfmember_version");
}
/*
http://iindigo.deviantart.com/art/World-of-Warcraft-X-Pac-Icons-62335583
*/
?>