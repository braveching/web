<?php 
require('php/_lof.php');

function EchoRelated()
{
	$strGroup = GetLofLinks();
	$strOil = GetOilSoftwareLinks();
	$strCommodity = GetCommoditySoftwareLinks();
	$strGold = GetGoldSoftwareLinks();
	$strCompany = GetCiticPruSoftwareLinks();
	
	echo <<< END
	<p><b>SZ165513大致对应跟踪GSG, 此处估算结果仅供参考.</b>
	<p><a href="https://xueqiu.com/4206051491/69865145" target=_blank>DBC和GSG的区别</a></p>
	<p> $strGroup
		$strOil
		$strCommodity
		$strGold
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
