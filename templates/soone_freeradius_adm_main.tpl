<!-- 今日連線統計 -->
<{if $op=="show_user_today" }>
<div class="container-fluid">
  <table class="table table-bordered table-striped">
    <tr>今日使用者統計</tr>
    <tr class="warning">
      <th>連線來源</th>
      <th>連線統計</th>
      <th>排名</th>
    </tr>
    <{foreach from=$show_user_today item=usertoday name=rank}>
      <tr>
        <td>
          <{$usertoday.username}>
        </td>
        <td>
          <{$usertoday.user_sum}>%
        </td>
        <td>
          <{$smarty.foreach.rank.iteration}>
        </td>
      </tr>
    <{/foreach}>
  </table>
</div>

<{elseif $op=="list_user" }>
  <div class="container">
    <table class="table table-bordered table-striped">
      <tr class="info">
        <th>編號</th>
        <th>帳號</th>
        <th>密碼</th>
        <th>姓名</th>
        <th>管理</th>
      </tr>
      <{foreach from=$content item=content}>
        <tr>
          <td>
            <{$content.id}>
          </td>
          <td><{$content.username}></td>
          <td><{$content.value}></td>
          <td><{$content.chtname}></td>
          <td>
            <a href="javascript:del_user(<{$content.id}>)" class="btn btn-danger btn-xs">刪除</a>
            <a href="main.php?id=<{$content.id}>" class="btn btn-warning btn-xs">修改</a>
          </td>
        </tr>
        <{/foreach}>
    </table>
  <{$bar}>
  </div>

<{else}>  
  <div class="container">
    <{$index_form}>
  </div>
<{/if}>