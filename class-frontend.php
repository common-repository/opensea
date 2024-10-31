<?php

//ADD OPENSEA JS
function openseasetup() {
	$options = get_option('opensea');
	if (!isset($options['osjs'])) {$options['js'] = "";}
	if ($options['osjs'] == 'on') {
		?><!-- Opensea NFT Embed WordPress Plugin by FireCask: https://firecask.com/opensea-nft-wordpress-plugin/ --><?php
		wp_enqueue_script( 'opensea-nft-card' );
	}

}
add_action('wp_head', 'openseasetup', 100);

function nftu_opensea_shortcode($openseaatts) {
	extract(shortcode_atts(array(
		"nftuos" => get_option('opensea'),
	), $openseaatts));

	if (!empty($openseaatts)) {
		foreach ($openseaatts as $key => $option)
			$nftuos[$key] = $option;
	}
	if (!empty($nftuos['width'])||$nftuos['width']!="") {$width = " width=\"".$nftuos['width']."\"";} else {}
	if (!empty($nftuos['height'])||$nftuos['height']!="") {$height = " height=\"".$nftuos['height']."\"";}
	if (empty($nftuos['refaddress'])||$nftuos['refaddress']=="") {$nftuos['refaddress'] = "0xbd6359c710dbc6342b0d41208dbb328be21ed9be";}
	if (isset($nftuos['orientation'])) {$osorientation = " orientationMode=\"manual\"";}
	if (empty($nftuos['link'])) {$link = "https://opensea.io/assets/ethereum/0x34195292dc07b0a0da1540d5a8b3bf6d509f06c4/695";} else {  $link=$nftuos['link'];}
	$path = parse_url($link, PHP_URL_PATH);
	$segments = explode('/', rtrim($path, '/'));
	if (strpos($path, 'matic') !== false) {$addressortoken = 'contractAddress';} else {$addressortoken = 'tokenAddress';}


	if (!empty($nftuos['osjs'])||$nftuos['osjs']!="") {wp_enqueue_script( 'opensea-nft-card' );}
	$openseabox =	"<!-- Opensea NFT Embed WordPress Plugin by NFTU: https://firecask.com/opensea-nft-wordpress-plugin/ --><nft-card ".$addressortoken."=\"".$segments[count($segments)-2]."\" tokenId=\"".$segments[count($segments)-1]."\" ></nft-card>";
	if (!empty($nftuos['attr'])) {
		$openseabox .= '<p><small><center>Powered by <a href="https://firecask.com/opensea-nft-wordpress-plugin/">Opensea WordPress Plugin</a></small></center></p>';
	}
	return $openseabox;
}
add_filter('widget_text', 'do_shortcode');
add_shortcode('opensea', 'nftu_opensea_shortcode');

?>