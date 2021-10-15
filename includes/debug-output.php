<?php if( DEBUG_MODE ){ ?>
<div class="debug-output">
	<h2>DEBUG MODE IS ON</h2>
	<pre><?php print_r( get_defined_vars() ); ?></pre>
</div>
<?php } ?>