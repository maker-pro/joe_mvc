<?php
/**
 * BookController.php
 * User: Joe
 * Date: 2023/3/21
 * Time: 14:37
 */

namespace App\Controller\WxApi\V1;

use App\Controller\BaseController;
use model\book\BookCategoryModel;

class BookController extends BaseController
{
    public function index()
    {
//        $redis = DB::getRedisInstance();
//        $this->returnResult($redis->get('name'));

//        $mysql = DB::getMysqlInstance();
//        $sql = 'select * from book_category;';
//        $rows = $mysql->getRows($sql);
//        $this->returnResult($rows);
        $book_category = new  BookCategoryModel();
        $this->returnResult($book_category->getAllCategory());
    }
}