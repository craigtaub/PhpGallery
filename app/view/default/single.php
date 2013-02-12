<div class="navigation">
<a href="<?php echo $url; ?>/">Home</a>
<?php if(is_array($navigation)): ?>
	<?php foreach($navigation as $nav):  ?>
		<?php if($nav['link']): ?>
		   &raquo;	<a href="<?php echo $nav['link'] ?>" title="<?php echo $nav['title'] ?>"><?php echo $nav['title'] ?></a>
		<?php else: ?>			
		   &raquo; <?php echo $nav['title'] ?>	
		<?php endif; ?>
		
	<?php endforeach;  ?>	
<?php endif; ?>
</div>
<div class="clear"></div>
<div class='paging'>
<?php if($prev): ?> <div class="floatleft"><a href="<?php echo $prev; ?>">Previous</a></div><?php endif; ?> 
<?php if($next): ?><div class="floatright"><a href="<?php echo $next; ?>">Next</a></div><?php endif; ?> 
</div> 
<div class="clear"></div>
	<div align="center" >
<?php if($fvalue):  ?>
<div style="width:600px;">
	<h2 class="alignleft" ><?php echo $fvalue['title'] ?></h2>
	<p><a href="<?php echo $fvalue['image'] ?>" title="<?php echo $fvalue['title'] ?>">
	<img src="<?php echo $fvalue['image_large'] ?>" alt="<?php echo $fvalue['title'] ?>" /></a></p>	
	<div class="clear">&nbsp;</div>	
	<p class="alignleft"><?php echo $fvalue['description'] ?></p>
	<div class="clear">&nbsp;</div>	
	<p class="alignleft"><?php echo html_entity_decode($fvalue['references']) ?></p>
	<div class="clear"></div>
	</div>	
<?php endif; ?>
</div>
