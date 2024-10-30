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

function coru_lfmember_game_page()
{

	global $wpdb;
	$coru_lfmember_game = $wpdb->prefix . "coru_lfmember_game";
	$coru_lfmember_list = $wpdb->prefix . "coru_lfmember_list";
	
	$game = substr($_GET['page'],14);
	
	$sql = $wpdb->prepare("SELECT * FROM " . $coru_lfmember_game . " WHERE LOWER(game_name_short)=LOWER('" . $game . "')");
	$selected_game = $wpdb->get_row($sql, ARRAY_A);
?>
<div class="wrap">
<h2>ZT LFMember Settings<?php if(!$_GET['action'] && !$posted) { ?> <a href="?page=<?php print $_GET['page'] ?>&amp;action=new" class="button add-new-h2" title="Add Position">Add Position</a><?php } ?></h2>
<h3><img src="<?php print plugins_url('/images/'.$selected_game['game_name_short'].'/'.$selected_game['game_image'], __FILE__); ?>" alt="<?php print $selected_game['game_name_short'] ; ?>" title="<?php print $selected_game['game_name_long'] ; ?>" style="vertical-align:middle;" /> <?php echo htmlspecialchars($selected_game['game_name_long']) ?></h3>

<?php
	if ($_POST['action2'] && $_POST['doaction_active'])
	{
	
		if($_POST['action2'] == 'activate-selected')
		{
			foreach ($_POST['checked'] as $id)
			{
				$wpdb->update( $coru_lfmember_list, array( 'position_open' => 1), array('id' => $id));
			}
		?>
				The selected positions have been opened. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
		<?php
		}
		
		if($_POST['action2'] == 'deactivate-selected')
		{
			foreach ($_POST['checked'] as $id)
			{
				$wpdb->update( $coru_lfmember_list, array( 'position_open' => 0), array('id' => $id));
			}
		?>
				The selected positions have been closed. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
		<?php
		}
		
		if($_POST['action2'] == 'delete-selected')
		{
			if (!$_POST['position_id'] && $_POST['checked'])
			{
?>
			<div><strong>Do you really want to delete the positions below? This action is permanent!</strong></div><br />
<?php

				$sql = $wpdb->prepare("SELECT * FROM " . $coru_lfmember_list . " WHERE id='" . $_GET['id'] . "' LIMIT 1");
				$result = $wpdb->get_row( $sql, ARRAY_A );
?>
<form method="post" action="?page=<?php print $_GET['page'] ?>">
	<div class="clear"></div>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Position Imagename</th>
				<th scope="col" class="manage-column">Position</th>
				<th scope="col" class="manage-column">Spots on Position available</th>
				<th scope="col" class="manage-column">Detail</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Open</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Position Imagename</th>
				<th scope="col" class="manage-column">Position</th>
				<th scope="col" class="manage-column">Spots on Position available</th>
				<th scope="col" class="manage-column">Detail</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Open</th>
			</tr>
		</tfoot>
		<tbody class="plugins">
		<?php
		
				foreach ($_POST['checked'] as $id)
				{
					$sql = $wpdb->prepare("SELECT * FROM " . $coru_lfmember_list . " WHERE id='" . $id . "' LIMIT 1");
					$result = $wpdb->get_row( $sql, ARRAY_A );
		?>
			<tr>
				<th scope="row" class="manage-column check-column"><input type="hidden" name="position_id[]" value="<?php print $result['id'] ?>" /></th>
				<td class="manage-column"><?php print $result['position_image'] ?></td>
				<td class="manage-column"><?php print stripslashes($result['position_name']) ?></td>
				<td class="manage-column"><?php print $result['position_need'] ?></td>
				<td class="manage-column"><?php print stripslashes($result['position_detail']) ?></td>
				<td class="manage-column"><?php print $result['position_link'] ?></td>
				<td class="manage-column check-column"><?php
					if ($result['position_open']==1) { ?>Yes<?php }
					if ($result['position_open']==0) { ?>No<?php } ?></td>
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
		
			if ($_POST['position_id'] && !$_POST['checked'])
			{
		
				foreach ($_POST['position_id'] as $id)
				{
					$wpdb->query($wpdb->prepare("DELETE FROM " . $coru_lfmember_list . " WHERE id=" . $id));
				}
			
?>
			The selected positions have been deleted. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
<?php
			}
		}
		
		if($_POST['action2'] == 'modify-selected')
		{
			if (!$_POST['position_id'] && $_POST['checked'])
			{
?>
<form method="post" action="?page=<?php print $_GET['page'] ?>">
	<div class="clear"></div>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Position Imagename</th>
				<th scope="col" class="manage-column">Position</th>
				<th scope="col" class="manage-column">Spots on Position available</th>
				<th scope="col" class="manage-column">Detail</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Open</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Position Imagename</th>
				<th scope="col" class="manage-column">Position</th>
				<th scope="col" class="manage-column">Spots on Position available</th>
				<th scope="col" class="manage-column">Detail</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Open</th>
			</tr>
		</tfoot>
		<tbody class="plugins">
<?php
			foreach ($_POST['checked'] as $id)
			{
				$sql = $wpdb->prepare("SELECT * FROM " . $coru_lfmember_list . " WHERE id='" . $id . "' LIMIT 1");
				$result = $wpdb->get_row( $sql, ARRAY_A );
?>
			<tr>
				<th scope="row" class="manage-column check-column"><input type="hidden" name="position_id[]" value="<?php print $result['id'] ?>" /></th>
				<td class="manage-column"><input type="text" value="<?php print $result['position_image'] ?>" name="position_image[]" /></td>
				<td class="manage-column"><input type="text" value="<?php print stripslashes($result['position_name']) ?>" name="position_name[]" /></td>
				<td class="manage-column"><input type="text" value="<?php print $result['position_need'] ?>" name="position_need[]" /></td>
				<td class="manage-column"><input type="text" value="<?php print stripslashes($result['position_detail']) ?>" name="position_detail[]" /></td>
				<td class="manage-column"><input type="text" value="<?php print $result['position_link'] ?>" name="position_link[]" /></td>
				<td class="manage-column check-column">
					<select name="position_open[]">
					<?php
					if ($result['position_open']==1)
					{
					?>
						<option value="1">Open</option>
						<option value="0">Close</option>
					<?php
					}
					
					if ($result['position_open']==0)
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
			if ($_POST['position_id'] && !$_POST['checked'])
			{
				$count = count($_POST['position_id']);
				for($i=0;$i<$count;$i++)
				{
					$wpdb->update( $coru_lfmember_list, array(
																'position_detail'	=> $_POST['position_detail'][$i],
																'position_image'	=> $_POST['position_image'][$i],
																'position_link'		=> $_POST['position_link'][$i],
																'position_name'		=> $_POST['position_name'][$i],
																'position_need'		=> $_POST['position_need'][$i],
																'position_open'		=> $_POST['position_open'][$i]
															),
														array('id' => $_POST['position_id'][$i]));
				}
		?>
				The selected positions have been updated. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
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
				<th scope="col" class="manage-column">Position Imagename</th>
				<th scope="col" class="manage-column">Position</th>
				<th scope="col" class="manage-column">Spots on Position available</th>
				<th scope="col" class="manage-column">Detail</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Open</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Position Imagename</th>
				<th scope="col" class="manage-column">Position</th>
				<th scope="col" class="manage-column">Spots on Position available</th>
				<th scope="col" class="manage-column">Detail</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Open</th>
			</tr>
		</tfoot>
		<tbody class="plugins">
			<tr>
				<th scope="row" class="manage-column check-column"><input type="hidden" name="game_id" value="" /></th>
				<td class="manage-column"><input type="text" value="" name="position_image" /></td>
				<td class="manage-column"><input type="text" value="" name="position_name" /></td>
				<td class="manage-column"><input type="text" value="" name="position_need" /></td>
				<td class="manage-column"><input type="text" value="" name="position_detail" /></td>
				<td class="manage-column"><input type="text" value="" name="position_link" /></td>
				<td class="manage-column check-column">
					<select name="position_open">
						<option value="0">Close</option>
						<option value="1">Open</option>
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
			$wpdb->insert( $coru_lfmember_list , array(
														'game_id'			=> $selected_game['id'],
														'position_detail'	=> $_POST['position_detail'],
														'position_image'	=> $_POST['position_image'],
														'position_link'		=> $_POST['position_link'],
														'position_name'		=> $_POST['position_name'],
														'position_need'		=> $_POST['position_need'],
														'position_open'		=> $_POST['position_open']
													)); 
?>
			Your position has been added. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
<?php
		}
	}
	
	if ($_GET['action']=='delete')
	{
		if (!$_POST['doaction_active'])
		{
?>
			<div><strong>Do you really want to delete the position below? This action is permanent!</strong></div><br />
<?php

			$sql = $wpdb->prepare("SELECT * FROM " . $coru_lfmember_list . " WHERE id='" . $_GET['id'] . "' LIMIT 1");
			$result = $wpdb->get_row( $sql, ARRAY_A );
?>
<form method="post" action="?page=<?php print $_GET['page'] ?>&amp;action=delete&amp;id=<?php print $_GET['id'] ?>">
	<div class="clear"></div>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Position Imagename</th>
				<th scope="col" class="manage-column">Position</th>
				<th scope="col" class="manage-column">Spots on Position available</th>
				<th scope="col" class="manage-column">Detail</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Open</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Position Imagename</th>
				<th scope="col" class="manage-column">Position</th>
				<th scope="col" class="manage-column">Spots on Position available</th>
				<th scope="col" class="manage-column">Detail</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Open</th>
			</tr>
		</tfoot>
		<tbody class="plugins">
			<tr>
				<th scope="row" class="manage-column check-column"><input type="hidden" name="position_id" value="<?php print $result['id'] ?>" /></th>
				<td class="manage-column"><?php print $result['position_image'] ?></td>
				<td class="manage-column"><?php print stripslashes($result['position_name']) ?></td>
				<td class="manage-column"><?php print $result['position_need'] ?></td>
				<td class="manage-column"><?php print stripslashes($result['position_detail']) ?></td>
				<td class="manage-column"><?php print $result['position_link'] ?></td>
				<td class="manage-column check-column"><?php
					if ($result['position_open']==1) { ?>Yes<?php }
					if ($result['position_open']==0) { ?>No<?php } ?></td>
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
			$wpdb->query($wpdb->prepare("DELETE FROM " . $coru_lfmember_list . " WHERE id=" . $_POST['position_id']));
			
?>
			The selected position has been deleted. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
<?php
		}
	}
	
	if ($_GET['action']=='modify' )
	{
		if (!$_POST['doaction_active'])
		{
			$sql = $wpdb->prepare("SELECT * FROM " . $coru_lfmember_list . " WHERE id='" . $_GET['id'] . "' LIMIT 1");
			$result = $wpdb->get_row( $sql, ARRAY_A );
?>
<form method="post" action="?page=<?php print $_GET['page'] ?>&amp;action=modify&amp;id=<?php print $_GET['id'] ?>">
	<div class="clear"></div>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Position Imagename</th>
				<th scope="col" class="manage-column">Position</th>
				<th scope="col" class="manage-column">Spots on Position available</th>
				<th scope="col" class="manage-column">Detail</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Open</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column check-column"> </th>
				<th scope="col" class="manage-column">Position Imagename</th>
				<th scope="col" class="manage-column">Position</th>
				<th scope="col" class="manage-column">Spots on Position available</th>
				<th scope="col" class="manage-column">Detail</th>
				<th scope="col" class="manage-column">Links to</th>
				<th scope="col" class="manage-column check-column">Open</th>
			</tr>
		</tfoot>
		<tbody class="plugins">
			<tr>
				<th scope="row" class="manage-column check-column"><input type="hidden" name="position_id" value="<?php print $result['id'] ?>" /></th>
				<td class="manage-column"><input type="text" value="<?php print $result['position_image'] ?>" name="position_image" /></td>
				<td class="manage-column"><input type="text" value="<?php print stripslashes($result['position_name']) ?>" name="position_name" /></td>
				<td class="manage-column"><input type="text" value="<?php print $result['position_need'] ?>" name="position_need" /></td>
				<td class="manage-column"><input type="text" value="<?php print stripslashes($result['position_detail']) ?>" name="position_detail" /></td>
				<td class="manage-column"><input type="text" value="<?php print $result['position_link'] ?>" name="position_link" /></td>
				<td class="manage-column check-column">
					<select name="position_open">
					<?php
					if ($result['position_open']==1)
					{
					?>
						<option value="1">Open</option>
						<option value="0">Close</option>
					<?php
					}
					
					if ($result['position_open']==0)
					{
					?>
						<option value="0">Close</option>
						<option value="1">Open</option>
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
				$wpdb->update( $coru_lfmember_list, array(
															'position_detail'	=> $_POST['position_detail'],
															'position_image'	=> $_POST['position_image'],
															'position_link'		=> $_POST['position_link'],
															'position_name'		=> $_POST['position_name'],
															'position_need'		=> $_POST['position_need'],
															'position_open'		=> $_POST['position_open']
														),
													array('id' => $_GET['id']));
		?>
				The selected position has been updated. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
		<?php
		}
	}
	
	if ($_GET['action']=='activate')
	{
		$wpdb->update( $coru_lfmember_list, array( 'position_open' => 1), array('id' => $_GET['id']));
		?>
				The selected positions have been opened. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
		<?php
	}
	
	if($_GET['action']=='deactivate')
	{
		$wpdb->update( $coru_lfmember_list, array( 'position_open' => 0), array('id' => $_GET['id']));
		?>
				The selected positions have been closed. <a href="?page=<?php print $_GET['page'] ?>">Continue</a>.
		<?php
	}
	
	if(!$_GET['action'] && !$posted)
	{
?>
<form method="post" action="?page=<?php print $_GET['page'] ?>">
	<div class="clear"></div>
	<table class="widefat" cellspacing="0" style="width:60em;">
		<thead>
			<tr>
				<th scope="col" class="manage-column check-column"><input type="checkbox" /></th>
				<th scope="col" class="manage-column" style="width:10em;">Position</th>
				<th scope="col" class="manage-column" style="width:20em;">Spots on Position available</th>
				<th scope="col" class="manage-column" style="width:10em;">Detail</th>
				<th scope="col" class="manage-column" style="width:20em;">Links to</th>
				<th scope="col" class="manage-column check-column">Open</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col" class="manage-column check-column"><input type="checkbox" /></th>
				<th scope="col" class="manage-column" style="width:10em;">Position</th>
				<th scope="col" class="manage-column" style="text-align:center;width:20em;">Spots on Position available</th>
				<th scope="col" class="manage-column" style="width:10em;">Detail</th>
				<th scope="col" class="manage-column" style="width:20em;">Links to</th>
				<th scope="col" class="manage-column check-column" style="text-align:center;width:5em;">Open</th>
			</tr>
		</tfoot>
		<tbody class="plugins">
		<?php
		$sql = $wpdb->prepare("SELECT * FROM " . $coru_lfmember_list . " WHERE game_id='" . $selected_game['id'] . "' ORDER BY position_name ASC");
		$result = $wpdb->get_results( $sql, ARRAY_A );
		
		$result_count = count($result);
		
		for ($i=0;$i<$result_count;$i++)
		{
		?>
			<tr <?php if($result[$i]['position_open']==1) { ?>class="active"<?php } else { ?>class="inactive"<?php } ?>>
				<th scope="row" class="check-column"><input type="checkbox" name="checked[]" value="<?php print $result[$i]['id'] ?>" /></th>
				<td class="plugin-title" style="width:10em;">
					<img src="<?php print plugins_url('/images/'.strtolower($selected_game['game_name_short']).'/'.$result[$i]['position_image'], __FILE__); ?>" alt="<?php print $result[$i]['position_name'] ; ?>" title="<?php print $result[$i]['position_name'] ; ?>" style="vertical-align:middle;" /> 
					<?php print $result[$i]['position_name'] ; ?>
				</td>
				<td class="desc" style="text-align:center;width:20em;"><?php print $result[$i]['position_need'] ; ?></td>
				<td class="desc" style="width:10em;"><?php print $result[$i]['position_detail'] ; ?></td>
				<td class="desc" style="width:10em;"><a href="<?php print $result[$i]['position_link'] ; ?>"><?php print $result[$i]['position_link'] ; ?></a></td>
				<td class="desc" style="text-align:center;width:5em;"><?php if($result[$i]['position_open']==1) { ?>Yes<?php } else { ?>No<?php } ?></td>
			</tr>
			<tr <?php if($result[$i]['position_open']==1) { ?>class="active second"<?php } else { ?>class="inactive second"<?php } ?>>
				<th scope="row" class="check-column"> </th>
				<td class="plugin-title" style="width:10em;">
					<div class="row-actions-visible"><span class="0"><?php if($result[$i]['position_open']==1) { ?><a href="?page=<?php print $_GET['page'] ?>&amp;action=deactivate&amp;id=<?php print $result[$i]['id'] ?>" title="<?php print 'Close' ?>"><?php print 'Close'; ?></a><?php } else { ?><a href="?page=<?php print $_GET['page'] ?>&amp;action=activate&amp;id=<?php print $result[$i]['id'] ?>" title="<?php print 'Open' ?>"><?php print 'Open'; ?></a><?php } ?></span> | <span class="1"><a href="?page=<?php print $_GET['page'] ?>&amp;action=delete&amp;id=<?php print $result[$i]['id'] ?>" title="<?php print 'Delete'; ?>"><?php print 'Delete'; ?></a></span> | <span class="2"><a href="?page=<?php print $_GET['page'] ?>&amp;action=modify&amp;id=<?php print $result[$i]['id'] ?>" title="<?php print 'Modify'; ?>"><?php print 'Modify'; ?></a></span></div>
				</td>
				<td class="desc" style="width:20em;"></td>
				<td class="desc" style="width:10em;"></td>
				<td class="desc" style="width:20em;"></td>
				<td class="desc" style="width:5em;"></td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<div class="tablenav">
		<div class="alignleft actions">
			<select name="action2">
				<option value="" selected="selected">Bulk Actions</option>
				<option value="activate-selected">Open</option>
				<option value="deactivate-selected">Close</option>
				<option value="modify-selected">Modify</option>
				<option value="delete-selected">Delete</option>
			</select>
			<input type="submit" name="doaction_active" value="Apply" class="button-secondary action" />
		</div>
	</div>
</form>
<?php
	}
?>
	<div class="clear"></div>
</div>
<?php
}
?>