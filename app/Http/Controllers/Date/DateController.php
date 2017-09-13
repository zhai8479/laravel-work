<?php
/**
 * Created by PhpStorm.
 * User: ZT
 * Date: 2017/9/13/0013
 * Time: 23:50
 */
namespace App\Http\Controllers\Date;

use App\Http\Controllers\Controller;
class DateController extends Controller
{
    public function date()
    {
        return'this is date';
    }
    public function show()
    {
        return'show date';
    }
}