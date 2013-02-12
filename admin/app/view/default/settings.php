<form enctype="multipart/form-data" method="post" action="index.php?c=settings/save">
<table cellpadding="0" cellspacing="5" border="0" class="tborder bborder" width="100%">
<tr><td colspan="6" align="left" class="admin">
		Settings
</td></tr>
<?php if($fvalue['msg']): ?>
	<tr><td colspan="2" align="center"><?php echo $fvalue['msg']; ?></td></tr>
<?php endif; ?>	
<?php foreach($fvalue as $key=>$val): ?>
<tr class="<?php echo fmod($key,2)?'altrow':''; ?>"><td width="300px"><?php echo $val['notes']; ?>:</td><td>

<?php if(in_array($val['key'],$yn_dropdown)): ?>
<select name="fvalue[<?php echo $val['flag']; ?>]">
			<option value="1" <?php echo $val['value']==1?'selected':'';?>>Yes</option>
			<option value="0" <?php echo $val['value']==0?'selected':'';?>>No</option>
			</select>
<?php else: ?>
<input type="text" name="fvalue[<?php echo $val['flag']; ?>]" id="title" value="<?php echo $val['value']; ?>"  size="47"  />
<?php endif; ?>

</td></tr>
<?php endforeach; ?>
	<tr><td colspan="2" align="center"><input value="Save" type="submit" class="button" /></td></tr>

</table>

</form>
