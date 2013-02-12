<div class="navigation">
	Galleries
</div>
<div class="clear"></div>
<div id="container">
<?php if(count($fvalue)):
		foreach($fvalue as $key=>$val):
?>
           <div class="gallerybox" onmouseover="this.className='itemhover gallerybox'" onmouseout="this.className='gallerybox'">
                <h2><a href="<?php echo $val['link'] ?>" rel="bookmark" title="<?php echo $val['name'] ?>">
                <?php echo $val['name'] ?></a></h2>
                <p><a href="<?php echo $val['link'] ?>" title="<?php echo $val['name'] ?>">
                <img src="<?php echo $val['image'] ?>" alt="<?php echo $val['name'] ?>" /></a></p>	
                <div class="pictext"><?php echo $val['albums'] ?> Albums</div>
                <div class="clear"></div>
           </div>
           <?php if(!fmod($key+1,3)):?><div class="clear"></div><?php endif; ?>
<?php   endforeach;
       endif;
?>
</div>
