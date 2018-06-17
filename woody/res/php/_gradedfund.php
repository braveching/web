<?php
require_once('_stock.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/referenceparagraph.php');

class _GradedFundGroup extends _StockGroup 
{
    var $bCanTradeM;
    
    // constructor
    function _GradedFundGroup($strSymbol) 
    {
        StockPrefetchData(array($strSymbol));
        $this->ref = new GradedFundReference($strSymbol);
        
        $arRef = array($this->ref->stock_ref, $this->ref->b_ref->stock_ref);
        $this->bCanTradeM = $this->ref->m_ref->stock_ref->bHasData; 
        if ($this->bCanTradeM)
        {
            $arRef[] = $this->ref->m_ref->stock_ref;     
        }

        parent::_StockGroup($arRef);
    } 
} 

// ****************************** Functions *******************************************************
function _gradedFundRefCallbackData($ref, $bChinese)
{
   	$ar = array();
    $ar[] = $ref->strPrice;
    $ar[] = $ref->GetPriceDisplay($ref->fOfficialNetValue);
    $ar[] = $ref->GetPriceDisplay($ref->fFairNetValue);
    return $ar;
}

function _gradedFundRefCallback($bChinese, $ref = false)
{
    if ($ref)
    {
    	$sym = $ref->GetSym();
    	if ($sym->IsFundA())
    	{
    		return _gradedFundRefCallbackData($ref->extended_ref, $bChinese);
    	}
    	return array('', '', '');
    }
    
	$arFundEst = GetFundEstTableColumn($bChinese);
    $arColumn = array();
    $arColumn[] = $arFundEst[7];
    $arColumn[] = $arFundEst[1];
    $arColumn[] = $arFundEst[3];
    return $arColumn;
}

function _set_extended_ref($ref)
{
	$ref->stock_ref->extended_ref = $ref;
}

function EchoAll($bChinese = true)
{
    global $group;
    $ref = $group->ref;
    $b_ref = $ref->b_ref;
    $m_ref = $ref->m_ref;

	_set_extended_ref($ref);
	_set_extended_ref($m_ref);
	_set_extended_ref($b_ref);
    EchoReferenceParagraph(array($ref->est_ref, $m_ref->stock_ref, $ref->stock_ref, $b_ref->stock_ref), $bChinese, _gradedFundRefCallback);
    EchoFundTradingParagraph($ref, $bChinese);    
    EchoFundTradingParagraph($b_ref, $bChinese);    
    if ($group->bCanTradeM)
    {
        EchoFundTradingParagraph($m_ref, $bChinese);    
    }

    EchoFundHistoryParagraph($ref, $bChinese);
    EchoFundHistoryParagraph($b_ref, $bChinese);
    if ($group->bCanTradeM)
    {
        EchoFundHistoryParagraph($m_ref, $bChinese);
    }
    
    if ($group->strGroupId) 
    {
        _EchoTransactionParagraph($group, $bChinese);
	}
    
    EchoPromotionHead($bChinese, 'gradedfund');
}

function GradedFundEchoTitle($bChinese = true)
{
    global $group;
    
    $str = _GetStockDisplay($group->ref->stock_ref, $bChinese);
    if ($bChinese)  $str .= '分析工具';
    else              $str .= ' Analysis Tool';
    echo $str;
}

function GradedFundEchoMetaDescription($bChinese = true)
{
    global $group;
    
    $str = _GetStockDisplay($group->ref->stock_ref, $bChinese);
    if ($bChinese)  $str .= '和它相关的母基金以及分级B的净值分析计算网页工具. 分级基金是个奇葩设计, 简直就是故意给出套利机会, 让大家来交易增加流动性.';
    else              $str .= ' and its related funds net value calculation and analysis.';
    EchoMetaDescriptionText($str);
}

    AcctNoAuth();
    $group = new _GradedFundGroup(StockGetSymbolByUrl());
    
?>
