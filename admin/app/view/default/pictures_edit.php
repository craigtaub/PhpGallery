<form enctype="multipart/form-data" method="post" action="index.php?c=pictures/save">
<table cellpadding="0" cellspacing="5" border="0" class="tborder" width="100%">
<tr><td colspan="6" align="left"  class="admin">
		Pictures :- <?php echo $gvalue['name']; ?> &raquo; <?php echo $avalue['title']; ?>
</td></tr>
<?php if($fvalue['msg']): ?>
	<tr><td colspan="2" align="center"><?php echo $fvalue['msg']; ?></td></tr>
<?php endif; ?>	
<tr><td>Gallery:</td><td><select name="gallery_id" id="galleryDropdown">
			<option>Select Gallery</option>
			<?php echo $gallery_dropdown; ?>
			</select></td></tr>
<tr><td>Album:</td><td><span id="album_dropdown"><select name="album_id">
			<option>Select Album</option>
			<?php echo $albums_dropdown; ?>
			</select></span></td></tr>
<tr><td>Title:</td><td><input type="text" name="fvalue[title]" id="title" value="<? echo $fvalue['title']; ?>"  size="60"  /></td></tr>
<tr><td>Description:</td><td><textarea rows="3" cols="60" name="fvalue[description]" id="description" ><? echo $fvalue['description']; ?></textarea></td></tr>
<tr><td>Image :</td><td><input type="file" name="image" id="image"  size="60"  /><br />
	<?php if($fvalue['image']): ?><div align="center"><a href="<? echo HTTP_IMAGE."/".$fvalue['image']; ?>" target="_blank">View Existing Image</a></div><?php endif; ?></td></tr>

<tr><td>References:</td><td><textarea rows="3" cols="60" name="fvalue[references]" id="references" ><? echo $fvalue['references']; ?></textarea></td></tr>


<tr><td colspan="2" align="center">    
    <input name="fvalue[picture_id]" id="picture_id" type="hidden" value="<? echo $fvalue['picture_id']; ?>"  size="60"  />
    <input name="fvalue[old_image]" id="image" type="hidden" value="<? echo $fvalue['image']; ?>"  size="60"  />
    <input type="submit" value="Save" class="button"/>
    <?php if($album_id): ?><input type="button" onclick="location.href='index.php?c=pictures&album_id=<? echo $album_id; ?>'" class="button" value="Back"/><?php endif; ?>
</td></tr>		
</table>
</form>
