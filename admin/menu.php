<?php
$adminmenu = array();

$i                      = 1;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_HOME;
$adminmenu[$i]['link']  = 'admin/index.php';
$adminmenu[$i]['desc']  = _MI_TAD_ADMIN_HOME_DESC;
$adminmenu[$i]['icon']  = 'images/admin/home.png';

$i++;
$adminmenu[$i]['title'] = '察看帳號';
$adminmenu[$i]['link']  = "admin/main.php?op=list_user";
$adminmenu[$i]['desc']  = '察看帳號';
$adminmenu[$i]['icon']  = 'images/admin/button.png';

$i++;
$adminmenu[$i]['title'] = '新增帳號';
$adminmenu[$i]['link']  = "admin/main.php?op=add_form";
$adminmenu[$i]['desc']  = '新增帳號';
$adminmenu[$i]['icon']  = 'images/admin/button.png';

$i++;
$adminmenu[$i]['title'] = '今日使用者';
$adminmenu[$i]['link']  = "admin/main.php?op=show_user_today";
$adminmenu[$i]['desc']  = '今日使用者';
$adminmenu[$i]['icon']  = 'images/admin/button.png';

$i++;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_ABOUT;
$adminmenu[$i]['link']  = 'admin/about.php';
$adminmenu[$i]['desc']  = _MI_TAD_ADMIN_ABOUT_DESC;
$adminmenu[$i]['icon']  = 'images/admin/about.png';
