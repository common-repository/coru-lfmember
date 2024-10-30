<?php
/*
Plugin Name: Coru LFMember
Plugin URI: http://www.ruelicke.net/plugins/coru-lfmember
Description: A Plugin to show that your guild or clan is looking for members. <strong>Disabling the Plugin will remove any created games and positions!</strong>
Version: 1.0.2
Author: Marco Rülicke
Author URI: http://www.ruelicke.net
License: GPL2
*/

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
require("coru-lfmember-db.php");
require("coru-lfmember-game-page.php");
require("coru-lfmember-main-page.php");
require("coru-lfmember-options.php");

register_activation_hook(__FILE__,'coru_lfmember_db_install');
register_deactivation_hook(__FILE__,'coru_lfmember_db_uninstall');

function coru_lfmember()
{
	//$wpdb->show_errors();
}

function coru_lfmember_display($game,$return_array,$before='',$after='')
{
	if(!empty($game))
	{
		global $wpdb;
		$coru_lfmember_game = $wpdb->prefix . "coru_lfmember_game";
		$coru_lfmember_list = $wpdb->prefix . "coru_lfmember_list";
		
		$sql = $wpdb->prepare("SELECT * FROM " . $coru_lfmember_list . " WHERE game_id=(SELECT id FROM " . $coru_lfmember_game . " WHERE LOWER(game_name_short)=LOWER('".$game."') AND game_enabled='1') AND position_open=1");
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		if (!empty($result))
		{
			if (!$return_array)
			{
				foreach ($result as $array)
				{
					print $before;
					?>
					<img src="<?php echo get_option('home'); ?>/wp-content/plugins/coru-lfmember/images/<?php echo strtolower($game); ?>/<?php echo $array['position_image']; ?>" alt="<?php echo $array['position_name']; ?>" title="<?php echo $array['position_name']; ?>" /> <a href="<?php echo $array['position_link']; ?>" title="Bewerben"><?php echo $array['position_need']; ?> <?php echo $array['position_detail']; ?></a>
					<?php
					print $after;
				}
			}
			
			if ($return_array)
			{
				$i = 0;
				foreach ($result as $array)
				{
					$the_array[$i]	= array(
												'id'				=> $array['id'] ,
												'game_id'			=> $array['game_id'],
												'position_detail'	=> $array['position_detail'],
												'position_image'	=> get_option('home').'/wp-content/plugins/coru-lfmember/images/' . strtolower($game),
												'position_link'		=> $array['position_link'],
												'position_name'		=> $array['position_name'],
												'position_need'		=> $array['position_need'],
												'position_open'		=> $array['position_open']	
											);
					$i++;
				}
				return $the_array;
			}
		}
		else
		{
			print $before . "All available spots filled. Feel free to apply anyway." . $after;
		}
	}
	else
	{
		print $before . $after;
	}
}
?>
