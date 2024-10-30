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

function coru_lfmember_main_page()
{
	global $wpdb;
	$coru_lfmember_game = $wpdb->prefix . "coru_lfmember_game";
	$coru_lfmember_list = $wpdb->prefix . "coru_lfmember_list";
?>
<div class="wrap">
<h2>ZT LFMember Settings<?php if(!$_GET['action'] && !$posted) { ?> <a href="?page=coru_lfmember_admin&amp;action=new" class="button add-new-h2">Add New</a><?php } ?></h2>
<?php
	if ($_POST['action2'] && $_POST['doaction_active'])
	{
	
		if($_POST['action2'] == 'activate-selected')
		{
			foreach ($_POST['checked'] as $id)
			{
				$wpdb->update( $coru_lfmember_game, array( 'game_enabled' => 1), array('id' => $id));
			}
		?>
				The selected games have been activated. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
		<?php
		}
		
		if($_POST['action2'] == 'deactivate-selected')
		{
			foreach ($_POST['checked'] as $id)
			{
				$wpdb->update( $coru_lfmember_game, array( 'game_enabled' => 0), array('id' => $id));
			}
		?>
				The selected games have been deactivated. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
		<?php
		}
		
		if($_POST['action2'] == 'delete-selected')
		{
			if (!$_POST['game_id'] && $_POST['checked'])
			{
?>
			<div><strong>Do you really want to delete the games below? All positions connected with these games will also be deleted. This action is permanent!</strong></div><br />
<?php

				$sql = $wpdb->prepare("SELECT * FROM " . $coru_lfmember_game . " WHERE id='" . $_GET['id'] . "' LIMIT 1");
				$result = $wpdb->get_row( $sql, ARRAY_A );
?>
<form method="post" action="?page=<?php print $_GET['page'] ?>">
	<div class="clear"></div>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Game Image Name</th>
				<th scope="col" class="manage-column">Game Short Name</th>
				<th scope="col" class="manage-column">Game Long Name</th>
				<th scope="col" class="manage-column">Game Description</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Active</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Game Image Name</th>
				<th scope="col" class="manage-column">Game Short Name</th>
				<th scope="col" class="manage-column">Game Long Name</th>
				<th scope="col" class="manage-column">Game Description</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Active</th>
			</tr>
		</tfoot>
		<tbody class="plugins">
		<?php
		
				foreach ($_POST['checked'] as $id)
				{
					$sql = $wpdb->prepare("SELECT * FROM " . $coru_lfmember_game . " WHERE id='" . $id . "' LIMIT 1");
					$result = $wpdb->get_row( $sql, ARRAY_A );
		?>
			<tr>
				<th scope="row" class="manage-column check-column"><input type="hidden" name="game_id[]" value="<?php print $result['id'] ?>" /></th>
				<td class="manage-column"><?php print $result['game_image'] ?></td>
				<td class="manage-column"><?php print stripslashes($result['game_name_short']) ?></td>
				<td class="manage-column"><?php print stripslashes($result['game_name_long']) ?></td>
				<td class="manage-column"><?php print stripslashes($result['game_description']) ?></td>
				<td class="manage-column"><?php print $result['game_link'] ?></td>
				<td class="manage-column check-column"><?php
					if ($result['game_enabled']==1) { ?>Yes<?php }
					if ($result['game_enabled']==0) { ?>No<?php } ?></td>
			</tr>
		<?php
		
				}
		?>
		</tbody>
	</table>
	<div class="tablenav">
		<div class="alignleft actions">
			<input type="hidden" name="action2" value="delete-selected" />
			<a href="?page=<?php print $_GET['page'] ?>" class="button-secondary action">Cancel</a> <input type="submit" name="doaction_active" value="Delete" class="button-secondary action" />
		</div>
	</div>
	<div class="clear"></div>
</form>
<?php
			}
		
			if ($_POST['game_id'] && !$_POST['checked'])
			{
		
				foreach ($_POST['game_id'] as $id)
				{
					$wpdb->query($wpdb->prepare("DELETE FROM " . $coru_lfmember_list . " WHERE game_id=" . $id));
					$wpdb->query($wpdb->prepare("DELETE FROM " . $coru_lfmember_game . " WHERE id=" . $id));
				}
			
?>
			The selected games and all positions connected to them have been deleted. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
<?php
			}
		}
		
		if($_POST['action2'] == 'modify-selected')
		{
			if (!$_POST['game_id'] && $_POST['checked'])
			{
?>
<form method="post" action="?page=<?php print $_GET['page'] ?>">
	<div class="clear"></div>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Game Image Name</th>
				<th scope="col" class="manage-column">Game Short Name</th>
				<th scope="col" class="manage-column">Game Long Name</th>
				<th scope="col" class="manage-column">Game Description</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Active</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Game Image Name</th>
				<th scope="col" class="manage-column">Game Short Name</th>
				<th scope="col" class="manage-column">Game Long Name</th>
				<th scope="col" class="manage-column">Game Description</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Active</th>
			</tr>
		</tfoot>
		<tbody class="plugins">
<?php
			foreach ($_POST['checked'] as $id)
			{
				$sql = $wpdb->prepare("SELECT * FROM " . $coru_lfmember_game . " WHERE id='" . $id . "' LIMIT 1");
				$result = $wpdb->get_row( $sql, ARRAY_A );
?>
			<tr>
				<th scope="row" class="manage-column check-column"><input type="hidden" name="game_id[]" value="<?php print $result['id'] ?>" /></th>
				<td class="manage-column"><input type="text" value="<?php print $result['game_image'] ?>" name="game_image[]" /></td>
				<td class="manage-column"><?php print stripslashes($result['game_name_short']) ?></td>
				<td class="manage-column"><input type="text" value="<?php print stripslashes($result['game_name_long']) ?>" name="game_name_long[]" /></td>
				<td class="manage-column"><textarea name="game_description[]" rows="4" cols="10"><?php print stripslashes($result['game_description']) ?></textarea></td>
				<td class="manage-column"><input type="text" value="<?php print $result['game_link'] ?>" name="game_link[]" /></td>
				<td class="manage-column check-column">
					<select name="game_enabled[]">
					<?php
					if ($result['game_enabled']==1)
					{
					?>
						<option value="1">Open</option>
						<option value="0">Close</option>
					<?php
					}
					
					if ($result['game_enabled']==0)
					{
					?>
						<option value="1">Open</option>
						<option value="0">Close</option>
					<?php
					}
					?>
					</select>
				</td>
			</tr>
<?php
			}
?>
		</tbody>
	</table>
	<div class="tablenav">
		<div class="alignleft actions">
			<input type="hidden" name="action2" value="modify-selected" />
			<input type="submit" name="doaction_active" value="Apply" class="button-secondary action" />
		</div>
	</div>
	<div class="clear"></div>
</form>
<?php
			}
			if ($_POST['game_id'] && !$_POST['checked'])
			{
				$count = count($_POST['game_id']);
				for($i=0;$i<$count;$i++)
				{
					$wpdb->update( $coru_lfmember_game, array(
																'game_description'	=> $_POST['game_description'][$i],
																'game_image'		=> $_POST['game_image'][$i],
																'game_link'			=> $_POST['game_link'][$i],
																'game_name_long'	=> $_POST['game_name_long'][$i],
																'game_enabled'		=> $_POST['game_enabled'][$i]
															),
														array('id' => $_POST['game_id'][$i]));
				}
		?>
				The selected games have been updated. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
		<?php
			}
		}
		
		$posted = true;
	}
	
	if ($_GET['action']=='new')
	{
		if (!$_POST['doaction_active'])
		{
?>
<form method="post" action="?page=<?php print $_GET['page'] ?>&amp;action=new">
	<div class="clear"></div>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Game Image Name</th>
				<th scope="col" class="manage-column">Game Short Name</th>
				<th scope="col" class="manage-column">Game Long Name</th>
				<th scope="col" class="manage-column">Game Description</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Active</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Game Image Name</th>
				<th scope="col" class="manage-column">Game Short Name</th>
				<th scope="col" class="manage-column">Game Long Name</th>
				<th scope="col" class="manage-column">Game Description</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Active</th>
			</tr>
		</tfoot>
		<tbody class="plugins">
			<tr>
				<th scope="row" class="manage-column check-column"><input type="hidden" name="game_id" value="" /></th>
				<td class="manage-column"><input type="text" value="" name="game_image" /></td>
				<td class="manage-column"><input type="text" value="" name="game_name_short" /></td>
				<td class="manage-column"><input type="text" value="" name="game_name_long" /></td>
				<td class="manage-column"><textarea name="game_description" rows="4" cols="40"></textarea></td>
				<td class="manage-column"><input type="text" value="" name="game_link" /></td>
				<td class="manage-column check-column">
					<select name="game_enabled">
						<option value="0">No</option>
						<option value="1">Yes</option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="tablenav">
		<div class="alignleft actions">
			<input type="submit" name="doaction_active" value="Apply" class="button-secondary action" />
		</div>
	</div>
	<div class="clear"></div>
</form>
<?php
		}
		
		if ($_POST['doaction_active'])
		{
			if ($wpdb->query($wpdb->prepare("SELECT * FROM " . $coru_lfmember_game . " WHERE LOWER(game_name_short)=LOWER(" . $_POST['game_name_short'] . ")"))===false)
			{
				$wpdb->insert( $coru_lfmember_game , array(
															'game_description'	=> $_POST['game_description'],
															'game_enabled'		=> $_POST['game_enabled'],
															'game_image'		=> $_POST['game_image'],
															'game_link'			=> $_POST['game_link'],
															'game_name_long'	=> $_POST['game_name_long'],
															'game_name_short'	=> $_POST['game_name_short'],
														)); 
?>
				Your game has been added. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
<?php
			}
			else
			{
?>
			Your game has not been added because the Game Short Name "<?php print $_POST['game_name_short'] ?>" is already in use. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
<?php
			}
		}
	}
	
	if ($_GET['action']=='delete')
	{
		if (!$_POST['doaction_active'])
		{
?>
			<div><strong>Do you really want to delete the game below? All positions connected with this game will also be deleted. This action is permanent!</strong></div><br />
<?php

			$sql = $wpdb->prepare("SELECT * FROM " . $coru_lfmember_game . " WHERE id='" . $_GET['id'] . "' LIMIT 1");
			$result = $wpdb->get_row( $sql, ARRAY_A );
?>
<form method="post" action="?page=<?php print $_GET['page'] ?>&amp;action=delete&amp;id=<?php print $_GET['id'] ?>">
	<div class="clear"></div>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Game Image Name</th>
				<th scope="col" class="manage-column">Game Short Name</th>
				<th scope="col" class="manage-column">Game Long Name</th>
				<th scope="col" class="manage-column">Game Description</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Active</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Game Image Name</th>
				<th scope="col" class="manage-column">Game Short Name</th>
				<th scope="col" class="manage-column">Game Long Name</th>
				<th scope="col" class="manage-column">Game Description</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Active</th>
			</tr>
		</tfoot>
		<tbody class="plugins">
			<tr>
				<th scope="row" class="manage-column check-column"><input type="hidden" name="game_id" value="<?php print $result['id'] ?>" /></th>
				<td class="manage-column"><?php print $result['game_image'] ?></td>
				<td class="manage-column"><?php print stripslashes($result['game_name_short']) ?></td>
				<td class="manage-column"><?php print stripslashes($result['game_name_long']) ?></td>
				<td class="manage-column"><?php print stripslashes($result['game_description']) ?></td>
				<td class="manage-column"><?php print $result['game_link'] ?></td>
				<td class="manage-column check-column"><?php
					if ($result['game_enabled']==1) { ?>Yes<?php }
					if ($result['game_enabled']==0) { ?>No<?php } ?></td>
			</tr>
		</tbody>
	</table>
	<div class="tablenav">
		<div class="alignleft actions">
			<a href="?page=<?php print $_GET['page'] ?>" class="button-secondary action">Cancel</a> <input type="submit" name="doaction_active" value="Delete" class="button-secondary action" />
		</div>
	</div>
	<div class="clear"></div>
</form>
<?php
		}
		
		if ($_POST['doaction_active'])
		{
			$wpdb->query($wpdb->prepare("DELETE FROM " . $coru_lfmember_list . " WHERE game_id=" . $_POST['game_id']));
			$wpdb->query($wpdb->prepare("DELETE FROM " . $coru_lfmember_game . " WHERE id=" . $_POST['game_id']));
			
?>
			The selected game and all to positions connected to it have been deleted. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
<?php
		}
	}
	
	if ($_GET['action']=='modify')
	{
		if (!$_POST['doaction_active'])
		{
			$sql = $wpdb->prepare("SELECT * FROM " . $coru_lfmember_game . " WHERE id='" . $_GET['id'] . "' LIMIT 1");
			$result = $wpdb->get_row( $sql, ARRAY_A );
?>
<form method="post" action="?page=<?php print $_GET['page'] ?>&amp;action=modify&amp;id=<?php print $_GET['id'] ?>">
	<div class="clear"></div>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Game Image Name</th>
				<th scope="col" class="manage-column">Game Short Name</th>
				<th scope="col" class="manage-column">Game Long Name</th>
				<th scope="col" class="manage-column">Game Description</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Active</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Game Image Name</th>
				<th scope="col" class="manage-column">Game Short Name</th>
				<th scope="col" class="manage-column">Game Long Name</th>
				<th scope="col" class="manage-column">Game Description</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Active</th>
			</tr>
		</tfoot>
		<tbody class="plugins">
			<tr>
				<th scope="row" class="manage-column check-column"><input type="hidden" name="game_id" value="<?php print $result['id'] ?>" /></th>
				<td class="manage-column"><input type="text" value="<?php print $result['game_image'] ?>" name="game_image" /></td>
				<td class="manage-column"><?php print stripslashes($result['game_name_short']) ?></td>
				<td class="manage-column"><input type="text" value="<?php print stripslashes($result['game_name_long']) ?>" name="game_name_long" /></td>
				<td class="manage-column"><textarea name="game_description" rows="4" cols="40"><?php print stripslashes($result['game_description']) ?></textarea></td>
				<td class="manage-column"><input type="text" value="<?php print $result['game_link'] ?>" name="game_link" /></td>
				<td class="manage-column check-column">
					<select name="game_enabled">
					<?php
					if ($result['game_enabled']==1)
					{
					?>
						<option value="1">Yes</option>
						<option value="0">No</option>
					<?php
					}
					
					if ($result['game_enabled']==0)
					{
					?>
						<option value="0">No</option>
						<option value="1">Yes</option>
					<?php
					}
					?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="tablenav">
		<div class="alignleft actions">
			<input type="submit" name="doaction_active" value="Apply" class="button-secondary action" />
		</div>
	</div>
	<div class="clear"></div>
</form>
<?php
		}
		
		if ($_POST['doaction_active'])
		{
			$wpdb->update( $coru_lfmember_game, array(
														'game_image'		=> $_POST['game_image'],
														'game_name_long'	=> $_POST['game_name_long'],
														'game_description'	=> $_POST['game_description'],
														'game_link'			=> $_POST['game_link']
													),
												array('id' => $_GET['id']));
		?>
			The selected game has been updated. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
		<?php
		}
	}
	
	if ($_GET['action']=='activate')
	{
		$wpdb->update( $coru_lfmember_game, array( 'game_enabled' => 1), array('id' => $_GET['id']));
		?>
				The selected game has been activated. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
		<?php
	}
	
	if($_GET['action']=='deactivate')
	{
		$wpdb->update( $coru_lfmember_game, array( 'game_enabled' => 0), array('id' => $_GET['id']));
		?>
				The selected game has been deactivated. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
		<?php
	}
	
	if(!$_GET['action'] && !$posted)
	{
?>
<form method="post" action="?page=<?php print $_GET['page'] ?>">
	<div class="clear"></div>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="manage-column check-column"><input type="checkbox" /></th>
				<th scope="col" class="manage-column" style="width:30em;">Game</th>
				<th scope="col" class="manage-column">Description</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column check-column"><input type="checkbox" /></th>
				<th scope="col" class="manage-column" style="width:30em;">Game</th>
				<th scope="col" class="manage-column">Description</th>
			</tr>
		</tfoot>
		<tbody class="plugins">
<?php
		$sql = $wpdb->prepare("SELECT * FROM " . $coru_lfmember_game . " ORDER BY game_name_long ASC");
		$result = $wpdb->get_results( $sql, ARRAY_A );
		
		$result_count = count($result);
		if ($result_count > 0)
		{
			for ($i=0;$i<$result_count;$i++)
			{
?>
			<tr <?php if($result[$i]['game_enabled']==1) { ?>class="active"<?php } else { ?>class="inactive"<?php } ?>>
				<th scope="row" class="check-column"><input type="checkbox" name="checked[]" value="<?php print $result[$i]['id'] ?>" /></th>
				<td class="plugin-title" style="width:30em;">
					<img src="<?php print plugins_url('/images/'.$result[$i]['game_name_short'].'/'.$result[$i]['game_image'], __FILE__); ?>" alt="<?php print $result[$i]['game_name_short'] ; ?>" title="<?php print $result[$i]['game_name_long'] ; ?>" style="vertical-align:middle;" /> 
					<?php print $result[$i]['game_name_long'] ; ?>
				</td>
				<td class="desc"><?php print $result[$i]['game_description'] ?></td>
			</tr>
			<tr <?php if($result[$i]['game_enabled']==1) { ?>class="active second"<?php } else { ?>class="inactive second"<?php } ?>>
				<th scope="row" class="check-column"></th>
				<td class="plugin-title" style="width:30em;">
					<div class="row-actions-visible"><span class="0"><?php if($result[$i]['game_enabled']==1) { ?><a href="?page=<?php print $_GET['page'] ?>&amp;action=deactivate&amp;id=<?php print $result[$i]['id'] ?>" title="<?php print 'Deactivate' ?>"><?php print 'Deactivate'; ?></a><?php } else { ?><a href="?page=<?php print $_GET['page'] ?>&amp;action=activate&amp;id=<?php print $result[$i]['id'] ?>" title="<?php print 'Activate' ?>"><?php print 'Activate'; ?></a><?php } ?></span> | <span class="1"><a href="?page=<?php print $_GET['page'] ?>&amp;action=delete&amp;id=<?php print $result[$i]['id'] ?>" title="<?php print 'Delete'; ?>"><?php print 'Delete'; ?></a></span> | <span class="2"><a href="?page=<?php print $_GET['page'] ?>&amp;action=modify&amp;id=<?php print $result[$i]['id'] ?>" title="<?php print 'Modify'; ?>"><?php print 'Modify'; ?></a></span></div>
				</td>
				<td class="desc"><div class="row-actions-visible"><span class="0">Links to: <a href="<?php print $result[$i]['game_link'] ?>"><?php print $result[$i]['game_link'] ?></a></span></div></td>
			</tr>
<?php
			}
		}
?>
		</tbody>
	</table>
	<div class="tablenav">
		<div class="alignleft actions">
			<select name="action2">
				<option value="" selected="selected">Bulk Actions</option>
				<option value="activate-selected">Activate</option>
				<option value="deactivate-selected">Deactivate</option>
				<option value="modify-selected">Modify</option>
				<option value="delete-selected">Delete</option>
			</select>
			<input type="submit" name="doaction_active" value="Apply" class="button-secondary action" />
		</div>
	</div>
	<div class="clear"></div>
</form>
<?php
	}
 ?>
</div>
<?php
}
?>