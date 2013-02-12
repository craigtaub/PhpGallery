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
<div id="container">
<?php if(count($fvalue)):
	   	  foreach($fvalue as $key=>$val): ?>
		        <div class="picturebox" onmouseover="this.className='itemhover'" onmouseout="this.className='picturebox'">
                <h2><a href="<?php echo $val['link'] ?>" rel="bookmark" title="<?php echo $val['title'] ?>">
                <?php echo $val['title'] ?></a></h2>
                <p><a href="<?php echo $val['link'] ?>" title="<?php echo $val['title'] ?>">
                <img src="<?php echo $val['image'] ?>" alt="<?php echo $val['title'] ?>" /></a></p>	
                <div class="clear"></div>
                </div>
		<?php if(!fmod($key+1,4)): ?><div class="clear"></div><?php endif; ?>
				
<?php     endforeach;
       endif;
?>		
</div>			
<div class="clear"></div>	
<?php echo $pagination; ?>
<div class="clear"></div>
