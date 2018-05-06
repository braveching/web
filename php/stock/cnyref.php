<?php

// ****************************** CnyReference class *******************************************************
class CnyReference extends MysqlReference
{
//    public static $strDataSource = STOCK_EASTMONEY_FOREX;
    public static $strDataSource = STOCK_DB_FOREX;
    
    function _loadDatabaseData($strSymbol)
    {
    	$this->strSqlId = SqlGetStockId($strSymbol);
		$forex = new SqlForexHistory($this->strSqlId);
    	if ($history = $forex->GetNow())
    	{
    		$this->strPrice = $history['close'];
    		$this->strDate = $history['date'];
    		$this->strTime = '09:15:00';
    		if ($history_prev = SqlGetForexHistoryPrev($this->strSqlId, $this->strDate))
    		{
    			$this->strPrevPrice = $history_prev['close'];
    		}
    	}
        $this->strFileName = DebugGetChinaMoneyFile();
        $this->strExternalLink = GetReferenceRateForexLink($strSymbol);
    }
    
	function _updateHistory()
	{
		if (FloatNotZero(floatval($this->strOpen)) == false)
		{
			$this->EmptyFile();
			return;
		}
    
		$forex = new SqlForexHistory($this->strSqlId);
		if ($forex->GetByDate($this->strDate) == false)
		{
			SqlInsertForexHistory($this->strSqlId, $this->strDate, $this->strPrice);
		}    
	}

    // constructor 
    function CnyReference($strSymbol)
    {
        if (self::$strDataSource == STOCK_EASTMONEY_FOREX)
        {
        	$this->LoadEastMoneyCnyData($strSymbol);
        }
        else
        {
            $this->_loadDatabaseData($strSymbol);
        }
        parent::MysqlReference($strSymbol);
        if (self::$strDataSource != STOCK_DB_FOREX)
        {
        	if ($this->strSqlId)
        	{
        		$this->_updateHistory();
        	}
        }
    }       
}

?>
