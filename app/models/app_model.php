<?php
class AppModel extends Model {
	var $newEntry=false;
	
	
	function begin() {
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        $db->begin($this);
    }
    function commit() {
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        $db->commit($this);
    }
    function rollback() {
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        $db->rollback($this);
    }
    
    function create($data=array(),$filterKey=false)
    {
    	$this->newEntry=true;
    	return parent::create($data,$filterKey);
    }
    
    function __save($data, $options) {
    	$ret=parent::__save($data, $options);
    	if (isset($options['validate']) && $options['validate']=='only')
    	{
    		$this->newEntry=false;
    	}
    	
    	return $ret;
    }
    
    function usdate($check, $fieldname)
    {
    	$this->log($check,date('Y-m-d').'debug');
    	return true;
    }
	
}
?>