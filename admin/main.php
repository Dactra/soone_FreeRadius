<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "soone_freeradius_adm_main.tpl";
include_once "header.php";
include_once "../function.php";

/*-----------function區--------------*/

//預設表單
function index_form($id="")
{
    global $xoopsTpl, $xoopsDB;

    if (empty($id) ){
        $val['username']="";
        $val['value']="";
        $val['chtname']="";
        $op = "add_user"; 

    }else{
        $tbl=$xoopsDB->prefix('radcheck');
        $sql="SELECT * FROM `{$tbl}` WHERE `id` = '{$id}'";
        $result = $xoopsDB->query($sql) or web_error($sql);
        $val=$xoopsDB->fetchArray($result);
        $op="edit_user";
    }

    include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

    $form = new XoopsThemeForm('新增使用者', 'indexform', 'main.php', 'post', true);
    $form->addElement(new XoopsFormText('帳號', 'username', 40, 255, $val['username']), true);
    $form->addElement(new XoopsFormText('密碼', 'value', 40, 255, $val['value']), true);
    $form->addElement(new XoopsFormText('姓名', 'chtname', 40, 255, $val['chtname']), true);

    $Tray = new XoopsFormElementTray('', '&nbsp;', 'name');
    $form->addElement(new XoopsFormHidden('op', $op));
    $Tray->addElement(new XoopsFormHidden('id', $id));
    $Tray->addElement(new XoopsFormButton('', 'name', '送出', 'submit'));
    $Tray->addElement(new XoopsFormButton('', 'name', '清除', 'reset'));
    $form->addElement($Tray);
    $index_form = $form->render();
    $xoopsTpl->assign('index_form', $index_form);
   
}

//使用者列出
function list_user(){

    global $xoopsDB, $xoopsTpl;
    
     //取得所有註冊使用者
     $tbl      = $xoopsDB->prefix('radcheck');
     $sql      = "SELECT * FROM `{$tbl}` ORDER BY `id` DESC";

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
         $main['name'] = $myts->htmlSpecialChars($main['name']);
         $main['value'] = $myts->htmlSpecialChars($main['value']);
         $main['chtname'] = $myts->htmlSpecialChars($main['chtname']);
 
         $mains[] = $main;
     }
    $xoopsTpl->assign('content', $mains); 
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php";
    $sweet_alert = new sweet_alert();
    $sweet_alert->render("del_user", "main.php?op=del_user&id=", 'id');
}


//使用者新增
function add_user()
{
    global $xoopsDB;

    //過濾資料
    $username=clean_var('username',  '帳號');
    $value=clean_var('value',  '密碼');
    $chtname=clean_var('chtname',  '姓名');

    //寫SQL
    $tbl=$xoopsDB->prefix('radcheck');
    $sql = "INSERT INTO `$tbl` ( `username`, `attribute`, `op` ,`value`, `chtname`)
    VALUES ('{$username}', 'User-Password',':=','{$value}', '{$chtname}')";

    //送至資料庫
    $xoopsDB->query($sql) or web_error($sql);
    //取得流水號
    $id = $xoopsDB->getInsertId();
    return $id;

}

//使用者刪除
function del_user($id)
{
    global $xoopsDB;

    $tbl      = $xoopsDB->prefix('radcheck');
    $sql     = "DELETE FROM `{$tbl}` WHERE `id` = '{$id}'";
    $xoopsDB->queryF($sql) or web_error($sql);

}

//使用者修改
function edit_user(){
    global $xoopsDB ;
    
    $username      = clean_var('username', '帳號');
    $value     = clean_var('value', '密碼');
    $chtname     = clean_var('chtname', '姓名');
    $id      = clean_var('id', '編號');

    $sql = "UPDATE `" . $xoopsDB->prefix('radcheck') . "` SET
    `username`='{$username}',
    `value`='{$value}',
    `chtname`='{$chtname}'
    WHERE `id` = '{$id}' ";

    $xoopsDB->queryF($sql) or web_error($sql);
    
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
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$id = system_CleanVars($_REQUEST, 'id', 0, 'int');

switch ($op) {

    case "add_user":
        $id = add_user();
        redirect_header("main.php?op=add_form", 5, "新增使用者成功！");
        // header("location:main.php?op=add_form");
        exit;
        
    case "list_user":
        list_user();
        break;

    case "del_user":
        del_user($id);
        header("location:main.php?op=list_user");
        exit;

    case "edit_user":
        edit_user();
        header("location:main.php?op=list_user");
        exit;
    
    case "show_user_today":
        show_user_today();
        exit;

    default:
        index_form($id); 
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('op', $op);
include_once 'footer.php';
