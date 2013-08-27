<?php


class Kdecom_Db_Table_Abstract extends Zend_Db_Table_Abstract {

    public function fetchAll($where = null, $order = null, $count = null, $offset = null,$join=null) {
        
        if (!($where instanceof Zend_Db_Table_Select)) {
            $select = $this->select();
            
            if($join !== null){
                $select = $select->joinInner($name, $cond, $cols);
            }

            if ($where !== null) {
                $this->_where($select, $where);
            }

            if ($order !== null) {
                $this->_order($select, $order);
            }

            if ($count !== null || $offset !== null) {
                $select->limit($count, $offset);
            }

        } else {
            $select = $where;
        }
        
        

        $rows = $this->_fetch($select);

        $data  = array(
            'table'    => $this,
            'data'     => $rows,
            'readOnly' => $select->isReadOnly(),
            'rowClass' => $this->getRowClass(),
            'stored'   => true
        );

        $rowsetClass = $this->getRowsetClass();
        if (!class_exists($rowsetClass)) {
            require_once 'Zend/Loader.php';
            Zend_Loader::loadClass($rowsetClass);
        }
        return new $rowsetClass($data);
        if(!is_null($join)){
            
        }
        
    }
    
    
}