<?php 
require('php/_chinaetf.php');

function EchoRelated()
{
	$strGroup = GetChinaEtfLinks();
	$strCompany = GetChinaAmcSoftwareLinks();
	
	echo <<< END
	<p>$strGroup
	   $strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
