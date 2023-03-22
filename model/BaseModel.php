<?php
/**
 * BaseModel.php
 * User: Joe
 * Date: 2023/3/22
 * Time: 14:59
 */

namespace model;

use \common\DB;
use \common\Result;

class BaseModel
{
    protected $table = null;
    protected $where_array = [];
    protected $mysql_object = null;

    public function __construct()
    {
        $this->mysql_object = DB::getMysqlInstance();
        if (empty($this->table)) {
            Result::toJson([], Result::NOT_FOUND_TABLE, Result::NOT_FOUND_TABLE_MSG);
        }
    }

    protected function getRows($fields, $index_field = '')
    {
        $sql = 'select ';
        if ($fields == '*') {
            $sql .= '* ';
        } else if (is_array($fields)) {
            $sql .= '`' . implode('`, `', $fields) . '` ';;
        } else {
            $sql .= '`' . $fields . '` ';
        }
        $sql .= 'from `' . $this->table . '` ';

        if ($this->where_array) {
            $sql .= 'where ' . implode(' and ', $this->where_array);
        }
        if ($index_field) {
            $result = $this->mysql_object->getRows($sql, $index_field);
        } else {
            $result = $this->mysql_object->getRows($sql);
        }
        return $result;
    }

    protected function where($field, $operator = '=', $conditions = '')
    {
        if ($field && $operator) {
            if (is_array($conditions)) {
                $condition_string = '("' . implode('", "', array_map('addslashes', $conditions)) . '")';
            } else {
                $condition_string = '"' . addslashes($conditions) . '"';
            }
            $where_string = '`' . $field . '` ' . $operator . $condition_string;
            array_push($this->where_array, $where_string);
        }
        return $this;
    }


}