<form enctype="multipart/form-data" method="post" action="index.php?c=media/save">
<table cellpadding="0" cellspacing="5" border="0" class="tborder" width="100%">
<tr><td colspan="6" align="left"  class="admin">
Picture
</td></tr>
<?php if($fvalue['msg']): ?>
	<tr><td colspan="2" align="center"><?php echo $fvalue['msg']; ?></td></tr>
<?php endif; ?>	
<tr><td>Title:</td><td><input type="text" name="fvalue[title]" id="title" value="<? echo $fvalue['title']; ?>"  size="60"  /></td></tr>
<tr><td>Image :</td><td><input type="file" name="image" id="image"  size="60"  /><br />
	<?php if($fvalue['image']): ?><div align="center"><a href="<? echo HTTP_IMAGE."/".$fvalue['image']; ?>" target="_blank">View Existing Image</a></div><?php endif; ?></td></tr>


<tr><td colspan="2" align="center">    
    <input name="fvalue[picture_id]" id="picture_id" type="hidden" value="<? echo $fvalue['picture_id']; ?>"  size="60"  />
    <input name="fvalue[old_image]" id="image" type="hidden" value="<? echo $fvalue['image']; ?>"  size="60"  />
    <input type="submit" value="Save" class="button"/>
</td></tr>		
</table>
</form>
