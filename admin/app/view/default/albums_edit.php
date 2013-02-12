<form enctype="multipart/form-data" method="post" action="index.php?c=albums/save">
<table cellpadding="0" cellspacing="5" border="0" class="tborder" width="100%">
<tr><td colspan="6" align="left"  class="admin">

		Albums:- <?php if($gvalue['name']) echo $gvalue['name']." &raquo; "; ?>	 <?php if($fvalue['title']) echo $fvalue['title']." &raquo; "; ?>	
	</td></tr>
<?php if($msg): ?>
	<tr><td colspan="2" align="center"><?php echo $msg; ?></td></tr>
<?php endif; ?>	
<tr><td>Title:</td><td><input type="text" name="fvalue[title]" id="title" value="<? echo $fvalue['title']; ?>"  size="60"  /></td></tr>
<tr><td>Gallery:</td><td><select name="fvalue[gallery_id]" id="gallery_id">
				<option value="">Select Gallery</option>
				<?php echo $gallery_dropdown; ?>
				</select></td></tr>
<tr><td>Cover :</td><td><input type="file" name="image" id="image"  size="60"  /><br />
	<?php if($fvalue['image']): ?><div align="center"><a href="<? echo HTTP_IMAGE."/".$fvalue['image']; ?>" target="_blank">View Existing Image</a></div><?php endif; ?></td></tr>


<tr><td colspan="2" align="center">
		<input name="fvalue[album_id]" id="album_id" type="hidden" value="<? echo $fvalue['album_id']; ?>"  size="60"  />
		<input name="gallery_id" id="gallery_id" type="hidden" value="<? echo $gallery_id; ?>"  size="60"  />		
		<input name="fvalue[old_image]" id="image" type="hidden" value="<? echo $fvalue['image']; ?>"  size="60"  />				
		<input type="submit" value="Save" class="button"/>
        <?php if($gallery_id): ?><input type="button" onclick="location.href='index.php?c=albums&gallery_id=<? echo $gallery_id; ?>'" class="button" value="Back to Albums"/><?php endif; ?>
</td></tr>		
</table>

</form>
