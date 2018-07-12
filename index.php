<?php
/*-----------引入檔案區--------------*/
include_once "header.php";
$xoopsOption['template_main'] = "soone_freeradius_index.tpl";
include_once XOOPS_ROOT_PATH . "/header.php";

/*-----------function區--------------*/

//顯示預設頁面內容
function show_content()
{
    global $xoopsDB, $xoopsTpl;

    $today = date('Y-m-d');
    $tbl     = $xoopsDB->prefix('radpostauth');
    $sql     = "SELECT * FROM `{$tbl}` WHERE `authdate` > '{$today}' GROUP by `authdate` ORDER BY `id` DESC ";

    //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
    $PageBar = getPageBar($sql, 10, 10);
    $bar     = $PageBar['bar'];
    $sql     = $PageBar['sql'];
    $total   = $PageBar['total'];
    $xoopsTpl->assign('bar', $bar);
    $xoopsTpl->assign('total', $total);

    $result  = $xoopsDB->query($sql) or web_error($sql);

    while ($main = $xoopsDB->fetchArray($result)) {
        //過濾讀出內容
        $myts            = MyTextSanitizer::getInstance();
        $main['id'] = $myts->htmlSpecialChars($main['id']);
        $main['authdate'] = $myts->htmlSpecialChars($main['authdate']);
        $main['username'] = $myts->htmlSpecialChars($main['username']);
        $main['clientname'] = $myts->htmlSpecialChars($main['clientname']);

        $mains[] = $main;
    }

    //取得全部連線資料
    $tbl      = $xoopsDB->prefix('radpostauth');
    $sql      = "SELECT distinct `authdate` FROM `{$tbl}` ";
    $result   = $xoopsDB->query($sql) or web_error($sql);
    $total_num = $xoopsDB->getRowsNum($result);
    // $total_num  =   $total_num/2;

    //取得今日連線資料
    $today = date('Y-m-d');
    $tbl      = $xoopsDB->prefix('radpostauth');
    $sql      = "SELECT distinct `authdate` from `{$tbl}` where `authdate` > '{$today}' ";
    $result   = $xoopsDB->query($sql) or web_error($sql);
    $today_num = $xoopsDB->getRowsNum($result);
    // $today_num  =   $today_num/2;

    //取得今日不重複等登入連線
    $tbl      = $xoopsDB->prefix('radpostauth');
    $sql      = "SELECT distinct `username` FROM `{$tbl}` where `authdate` > '{$today}' ";
    $result   = $xoopsDB->query($sql) or web_error($sql);
    $today_login_num = $xoopsDB->getRowsNum($result);


    //取得所有註冊使用者數量
    $tbl      = $xoopsDB->prefix('radcheck');
    $sql      = "SELECT username FROM `{$tbl}` ";
    $result   = $xoopsDB->query($sql) or web_error($sql);
    $wifi_user_num = $xoopsDB->getRowsNum($result);

    $xoopsTpl->assign('today_num', $today_num);
    $xoopsTpl->assign('total_num', $total_num);
    $xoopsTpl->assign('today_login_num', $today_login_num);
    $xoopsTpl->assign('wifi_user_num', $wifi_user_num); 
    $xoopsTpl->assign('content', $mains); 

}

function show_count()
{
    global $xoopsDB, $xoopsTpl;

    $today = date('Y-m-d');
    $tbl     = $xoopsDB->prefix('radpostauth');
    $sql     = "SELECT * FROM `{$tbl}` WHERE `authdate` > '{$today}' GROUP by `authdate` ORDER BY `id` DESC ";

    //取得全部連線資料
    $tbl      = $xoopsDB->prefix('radpostauth');
    $sql      = "SELECT distinct `authdate` FROM `{$tbl}` ";
    $result   = $xoopsDB->query($sql) or web_error($sql);
    $total_num = $xoopsDB->getRowsNum($result);

    //取得今日連線資料
    $today = date('Y-m-d');
    $tbl      = $xoopsDB->prefix('radpostauth');
    $sql      = "SELECT distinct `authdate` from `{$tbl}` where `authdate` > '{$today}' ";
    $result   = $xoopsDB->query($sql) or web_error($sql);
    $today_num = $xoopsDB->getRowsNum($result);

    //取得今日不重複等登入連線
    $tbl      = $xoopsDB->prefix('radpostauth');
    $sql      = "SELECT distinct `username` FROM `{$tbl}` where `authdate` > '{$today}' ";
    $result   = $xoopsDB->query($sql) or web_error($sql);
    $today_login_num = $xoopsDB->getRowsNum($result);

    //取得所有註冊使用者數量
    $tbl      = $xoopsDB->prefix('radcheck');
    $sql      = "SELECT username FROM `{$tbl}` ";
    $result   = $xoopsDB->query($sql) or web_error($sql);
    $wifi_user_num = $xoopsDB->getRowsNum($result);

    $xoopsTpl->assign('today_num', $today_num);
    $xoopsTpl->assign('total_num', $total_num);
    $xoopsTpl->assign('today_login_num', $today_login_num);
    $xoopsTpl->assign('wifi_user_num', $wifi_user_num); 

}

function show_stastic_today(){

global $xoopsDB, $xoopsTpl;

    $today = date('Y-m-d');
    //取得全部連線數量
    $tbl      = $xoopsDB->prefix('radpostauth');
    $sql      = "SELECT `authdate` FROM `{$tbl}` where `authdate` > '{$today}'";
    $result   = $xoopsDB->query($sql) or web_error($sql);
    $total_num = $xoopsDB->getRowsNum($result);

    //統計各裝置數量
    $tbl     = $xoopsDB->prefix('radpostauth');   
    $sql     = "SELECT `clientname`,count(*) as 'client_sum' FROM `{$tbl}` where `authdate` > '{$today}' GROUP by `clientname` order by `client_sum` DESC";
    $result  = $xoopsDB->query($sql) or web_error($sql);

    while ($val = $xoopsDB->fetchArray($result)) {
        $val['client_sum'] = round ( $val['client_sum'] / $total_num, 3)*100 ;
        $main[] = $val;
    }

    $xoopsTpl->assign('statistic_today', $main);
}

function show_stastic_total(){

global $xoopsDB, $xoopsTpl;

    //取得全部連線資料
    $tbl      = $xoopsDB->prefix('radpostauth');
    $sql      = "SELECT `authdate` FROM `{$tbl}` ";
    $result   = $xoopsDB->query($sql) or web_error($sql);
    $total_num = $xoopsDB->getRowsNum($result);

    $tbl     = $xoopsDB->prefix('radpostauth');   
    $sql     = "SELECT `clientname`,count(*) as 'client_sum' FROM `{$tbl}` GROUP by `clientname` order by `client_sum` DESC";
    $result  = $xoopsDB->query($sql) or web_error($sql);

    while ($val = $xoopsDB->fetchArray($result)) {
        $val['client_sum'] = round ( $val['client_sum'] / $total_num, 3)*100 ;
        $main[] = $val;
    }

    $xoopsTpl->assign('statistic_total', $main);
}

function show_user_today(){

    global $xoopsDB, $xoopsTpl;

    $today = date('Y-m-d');
    //取得全部連線數量
    $tbl      = $xoopsDB->prefix('radpostauth');
    $sql      = "SELECT `authdate` FROM `{$tbl}` where `authdate` > '{$today}'";
    $result   = $xoopsDB->query($sql) or web_error($sql);
    $total_num = $xoopsDB->getRowsNum($result);

    //統計各裝置數量
    $tbl     = $xoopsDB->prefix('radpostauth');   
    $sql     = "SELECT `username`,count(*) as 'user_sum' FROM `{$tbl}` where `authdate` > '{$today}' GROUP by `username` order by `user_sum` DESC";
    $result  = $xoopsDB->query($sql) or web_error($sql);

    while ($val = $xoopsDB->fetchArray($result)) {
        $val['user_sum'] = round ( $val['user_sum'] / $total_num, 3)*100 ;
        $main[] = $val;
    }

    $xoopsTpl->assign('show_user_today', $main);
}


/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
// $op = system_CleanVars($_REQUEST, 'op', '', 'string');
// $id = system_CleanVars($_REQUEST, 'id', 0, 'int');

switch ($op) {

    // case "show_name":
    //     show_wifi_user();
    // header("location:{$_SERVER['PHP_SELF']}");
        // break;

    default:
    if($isAdmin){
        show_user_today();
        show_content();
    }
        show_count();
        show_stastic_today();
        show_stastic_total();
        break;
}

/*-----------秀出結果區--------------*/
// $xoopsTpl->assign('op', $op);
$xoopsTpl->assign("toolbar", toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('isAdmin', $isAdmin);
include_once XOOPS_ROOT_PATH . '/footer.php';