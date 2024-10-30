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

add_action('admin_menu', 'coru_lfmember_create_menu');
//load_plugin_textdomain('coru-lfmember','/wp-content/plugins/coru-lfmember/languages/');

function coru_lfmember_create_menu()
{

	//create new top-level menu
	add_menu_page('Coru LFMember Administration', 'LFMember', 'administrator', 'coru_lfmember_admin', 'coru_lfmember_main_page');
	
	//create new sub-level menu(s)
	global $wpdb;
	$coru_lfmember_game = $wpdb->prefix . "coru_lfmember_game";
	$sql = "SELECT game_name_short,game_name_long FROM " . $coru_lfmember_game . " WHERE game_enabled=1 ORDER BY game_name_long ASC";
	$result = $wpdb->get_results( $sql, ARRAY_A );
	if (!empty($result))
	{
		foreach ($result as $array)
		{
			add_submenu_page( 'coru_lfmember_admin', $array['game_name_long'] . ' membersearch', $array['game_name_long'], 'administrator', 'coru_lfmember_' . strtolower($array['game_name_short']), 'coru_lfmember_game_page');
		}
	}
}

?>