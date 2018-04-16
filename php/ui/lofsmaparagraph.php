<?php
require_once('smaparagraph.php');

function _callbackLofSma($fEst, $lof_ref)
{
	if ($fEst)		return $lof_ref->_estLofByEtf($fEst, $lof_ref->fCNY);
	return $lof_ref->stock_ref;
}

function EchoLofSmaParagraph($lof_ref, $callback2, $bChinese)
{
	$ref = $lof_ref->etf_ref;
    if ($ref == false) 				return;
    if ($ref->bHasData == false) 	return;
    
	$stock_his = new StockHistory($ref);
	$arColumn = EchoSmaParagraphBegin($stock_his, $bChinese);
	EchoSmaTable($arColumn, $stock_his, $lof_ref, _callbackLofSma, $callback2, $bChinese);
    EchoParagraphEnd();
}

?>