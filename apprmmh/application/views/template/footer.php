<?php $this->config->load("sitio"); ?>
<div id="footer" class="row">
	<div class="tencol">
		<?php echo $this->config->item("footer"); ?>		
	</div>
	<div class="twocol last">
		<a href="http://www.facebook.com/DANEColombia"><img src="<?php echo base_url("images/facebook.png"); ?>" width="30" height="30"></img></a>
		<a href="http://twitter.com/DANE_Colombia"><img src="<?php echo base_url("images/twitter.png"); ?>" width="30" height="30"></img></a>
		<a href="http://youtube.com/DaneColombia"><img src="<?php echo base_url("images/youtube.png"); ?>" width="30" height="30"></img></a>
	</div>
</div>