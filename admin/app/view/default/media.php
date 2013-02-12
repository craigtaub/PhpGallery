<style>
 select {
 	width:120px;
 }
</style>
<table width="100%" border="0" class="tborder">
   <tr><td align="left"  class="admin">
		Media Store: <br/>
		<span style="font-size:12px">upload an new image into the store and use its snippet anywhere</span>
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
				<th width="15%">Title</th>
				<th width="10%">Delete</th>
				<th>Snippet (copy and paste this into references box and the image will print)</th>
			</tr>			
			<?php foreach ($fvalue as $key=>$fval): ?>
			
			<tr class="<?php echo fmod($key,2)?'altrow':''; ?>">
				<td width="5%"><?php echo $record_start+$key+1;?></td>
				<td width="10%"><img src="<?php echo HTTP_THUMB."/".$fval['image'];?>" width="50" height="50" /></td>						
				<td width="15%"><?php echo $fval['title'];?></td>
				<td width="10%">
					 <a href="index.php?c=media/delete&id=<? echo $fval['id']; ?>" id="delete">Delete</a>
				</td>
				<?php $image = $fval['image'];?>
				<td><?php echo htmlentities('<img src="http://www.ginasgallery.co.uk/pictures/large/'. $image.'"/>'); ?></td>
					
			</tr>
			<?php endforeach; ?>
			</table>
		</td></tr>	
		<tr><td colspan="7" align="right">
				<span style="float:left"><?php echo $pagination; ?></span><?php if($album_id): ?><input type="submit" class="button" name="submit" value="Update" /><?php endif; ?>
		</td></tr>
		</table>
		<input type="hidden" name="record_start" value="<?php echo $record_start;?>" />
		<input type="hidden" name="page" value="<?php echo $page;?>" />
		</form>
	</td>	
	</tr>
	</table><br />
<div align="center"><input type="button" onclick="location.href='index.php?c=media/add'" class="button" value="Add Media"/> &nbsp; <input type="button" onclick="location.href='index.php?c=albums&gallery_id=<? echo $gallery_id; ?>'" class="button" value="Back"/></div>
