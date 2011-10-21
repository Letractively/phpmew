<?php

PhpMew2::load( 'Mew/View/Helper' );

class Mew_View_Helper_Database extends Mew_View_Helper
{
	function dump( $input = Array() )
	{
		echo '<pre><code>', "\n";
		print_r( $input );
		echo '</code></pre>', "\n";
	}
}

