<style>
 select {
 	width:120px;
 }
</style>
<table width="100%" border="0" class="tborder">
   <tr><td align="left"  class="admin">
		Pictures:- <?php if($gvalue['name']) echo $gvalue['name']." &raquo; "; ?><?php if($avalue['title']) echo $avalue['title'].""; ?>
   </td>
   <td align="right">
		   <form action="" method="get">
		   Gallery: <select name="gallery_id" id="galleryDropdown" style="width:120px">
				<option value="">Select Gallery</option>
				<?php echo $gallery_dropdown; ?>
				</select>
				Album:<span id="album_dropdown"><select name="album_id" style="width:120px">
			<option value="">Select Album</option>
			<?php echo $albums_dropdown; ?> 
			</select></span> <input type="submit" name="Search" value="Go" class="button" name="" />   
			<input type="hidden" name="c" value="pictures" />
		   </form>			
   </td>   
   </tr>
   <tr>
   <td valign="top" colspan="2">
   <form action="index.php?c=pictures/order" method="post">
		 <table width="100%" border="0" cellpadding="1" cellspacing="1">				 
		 <tr><td colspan="6">	
			<table width="100%" class="tborder bborder" cellpadding="1" cellspacing="1">
			<tr class="first" style="height:30px">
				<th width="5%">#</th>
				<th width="10%">Thumb</th>				
				<th width="40%">Title</th>
				<th width="10%">Album</th>									
				<th>Edit/Delete</th>
				<th width="15%">Order</th>		
			</tr>			
			<?php foreach ($fvalue as $key=>$fval): ?>
			
			<tr class="<?php echo fmod($key,2)?'altrow':''; ?>">
				<td width="5%"><?php echo $record_start+$key+1;?></td>
				<td width="10%"><img src="<?php echo HTTP_THUMB."/".$fval['image'];?>" width="50" height="50" /></td>						
				<td width="40%"><?php echo $fval['title']; ?></td>
				<td width="10%"><?php echo $fval['album_title']; ?></td>				
				<td>
					<a href="index.php?c=pictures/edit&picture_id=<? echo $fval['picture_id']; ?>&album_id=<? echo $fval['album_id']; ?>">Edit</a> / <a href="index.php?c=pictures/delete&picture_id=<? echo $fval['picture_id']; ?>&album_id=<? echo $fval['album_id']; ?>" id="delete">Delete</a></td>
				<td width="15%" align="center"><a href="javascript:;" class="moveup"><img src="<?php echo $tpath; ?>/images/up.png" border="0"/></a> <a href="javascript:;" class="movedown"><img src="<?php echo $tpath; ?>/images/down.png" border="0" /></a><input name="sortorder[]"  type="hidden" value="<?php echo $fval['picture_id']; ?>"/></td>
					
			</tr>
			<?php endforeach; ?>
			</table>
		</td></tr>	
		<tr><td colspan="7" align="right">
				<span style="float:left"><?php echo $pagination; ?></span><?php if($album_id): ?><input type="submit" class="button" name="submit" value="Update" /><?php endif; ?>
		</td></tr>
		</table>
		<input type="hidden" name="album_id" value="<? echo $album_id; ?>" />
		<input type="hidden" name="record_start" value="<?php echo $record_start;?>" />
		<input type="hidden" name="page" value="<?php echo $page;?>" />
		<input type="hidden" name="gallery_id" value="<? echo $gallery_id; ?>" />
		</form>
	</td>	
	</tr>
	</table><br />
<div align="center"><input type="button" onclick="location.href='index.php?c=pictures/add&album_id=<? echo $album_id; ?>'" class="button" value="Add Picture"/> &nbsp; <input type="button" onclick="location.href='index.php?c=albums&gallery_id=<? echo $gallery_id; ?>'" class="button" value="Back"/></div>
