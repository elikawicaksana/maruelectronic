<?php
 function formatUang($uang){
 	$convertFormat="Rp ".number_format($uang,0);
 	return $convertFormat;
 } 
?>