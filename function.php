<?php
//引入TadTools的函式庫
if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php")) {
    redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50", 3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php";

//其他自訂的共同的函數

//檢查並傳回欲拿到資料使用的變數
function clean_var($var , $title = '', $filter = '')
{
    $myts = MyTextSanitizer::getInstance();
    $var  = $myts->addSlashes($_REQUEST[$var]);
  
    if ($var=='' and !empty($title)) {
        throw new Exception("{$title}為必填！");
    } 
  
    if ($filter) {
        $var = filter_var($var, $filter);
        if (!$var) {
            throw new Exception("不合法的{$title}");
        }
    }
    return $var;
}
