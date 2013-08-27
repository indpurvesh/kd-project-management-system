<?php

class Application_Model_Table_Category extends Kdecom_Db_Table_Abstract {

    public $_name = 'category';

    public function getCategoryNamebyId($categoryId) {
        if ($categoryId == 0) {
            return "";
        }
        $category = $this->fetchRow('category_id = ' . intval($categoryId));
        return $category->category_name;
    }

    public function getNavOptions() {
        $sql = "SELECT      c.category_id , c.category_name , CONCAT(c.category_name,' (',COALESCE(count(j.job_id),0),')') as category_name_job
                FROM        category c
                LEFT JOIN   job j on c.category_id = j.category_id
                WHERE       c.parent_id is null OR j.job_date is null AND  j.job_date > '" . date("Y-m-d") . "'
                GROUP BY    c.category_id ,c.category_name 
                ORDER BY    c.category_name";
        //echo $sql;die; //AND  j.job_date > '".date("Y-m-d",strtotime('-1 months'))."'
        $query = $this->_db->query($sql);
        $result = $query->fetchAll();
        foreach ($result as $category) {
            $return[$category['category_id']] = array('category_name' => $category['category_name'], 'category_name_job' => $category['category_name_job']);
        }
        return $return;
    }

    public function getParentOptions($included = true) {
        //$this->fetchAll($where, $order);
        $result = $this->fetchAll($where = "parent_id IS NULL", 'category_name');
        $return = array('' => 'Select Category');

        foreach ($result as $category) {
            $return[$category->category_id] = $category->category_name;
        }

        return $return;
    }

    public function getSubCategoryOptions($parentId = "") {
        if($parentId == "") {
            return array('' => 'Select Sub Category');
        }
        $result = $this->fetchAll($where = "parent_id =" . $parentId);
        $return = array('' => 'Select Sub Category');
        foreach ($result as $category) {
            $return[$category->category_id] = $category->category_name;
        }

        return $return;
    }

}

