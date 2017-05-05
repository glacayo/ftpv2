<?php 
function hostingName ($urlCatch){
	$URL = parse_url( $urlCatch, PHP_URL_HOST );
	$WWW = "/^www./";
	if ( preg_match( $WWW, $URL ) ){
		$DNS = @dns_get_record( substr($URL, 4) );
		$resultadosDNS = count( $DNS );
		for ($i=0; $i < $resultadosDNS; $i++) { 
			if ( !empty( $DNS[$i]["target"] ) ) {
				if( preg_match("/^mx./", $DNS[$i]["target"]) ){
					echo " | Hosting: IPAGE";
					break;
				}else{
					if( $DNS[$i]["target"] == "ns2.bluehost.com" || $DNS[$i]["target"] == "ns1.bluehost.com" ){
						echo " | Hosting: BLUEHOST";
						break;
					}elseif ( $DNS[$i]["target"] == "ns2.justhost.com" || $DNS[$i]["target"] == "ns1.justhost.com" ) {
						echo " | Hosting: JUSTHOST";
						break;
					}//END ELSE IF
				}//END ELSE
			}//END IF
		}//END FOR
	}else{
		$DNS = @dns_get_record($URL);
		$resultadosDNS = count($DNS);
		for ($i=0; $i < $resultadosDNS; $i++) { 
			if (!empty($DNS[$i]["target"])) {
				if( preg_match("/^mx./", $DNS[$i]["target"]) ){
					echo " | Hosting: IPAGE";
					break;
				}else{
					if( $DNS[$i]["target"] == "ns2.bluehost.com" || $DNS[$i]["target"] == "ns1.bluehost.com" ){
						echo " | Hosting: BLUEHOST";
						break;
					}elseif ( $DNS[$i]["target"] == "ns2.justhost.com" || $DNS[$i]["target"] == "ns1.justhost.com" ) {
						echo " | Hosting: JUSTHOST";
						break;
					}//END ELSEIF
				}//END ELSE
			}//END IF
		}//END FOR
	}//END ELSE
}//END FUNCTION

?>