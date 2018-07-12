<center><h3>這是統計學校Radius Server的連線數量分析的xoops模組</h3></center>

<!--今日連線統計  -->
<div class="container-fluid">
    <table class="table table-bordered table-striped">
        <tr>今日總數:
            <{$today_num}>、 全部總數:
            <{$total_num}>、 帳號數量:
            <{$wifi_user_num}>、 今日不重複人次:
            <{$today_login_num}>
        </tr>
        <tr class="danger">
            <th>連線來源</th>
            <th>連線統計</th>
            <th>排名</th>
        </tr>
        <{foreach from=$statistic_today item=statistic name=rank}>
            <tr>
                <td>
                    <{$statistic.clientname}>
                </td>
                <td>
                    <{$statistic.client_sum}>%
                </td>
                <td>
                    <{$smarty.foreach.rank.iteration}>
                </td>
            </tr>
            <{/foreach}>
    </table>
</div>

<!-- 所有連線統計 -->
<div class="container-fluid">
    <table class="table table-bordered table-striped">
        <tr>所有連線統計</tr>
        <tr class="warning">
            <th>連線來源</th>
            <th>連線統計</th>
            <th>排名</th>
        </tr>
        <{foreach from=$statistic_total item=statistic name=rank}>
            <tr>
                <td><{$statistic.clientname}></td>
                <td><{$statistic.client_sum}>%</td>
                <td><{$smarty.foreach.rank.iteration}></td>
            </tr>
        <{/foreach}>
    </table>
</div>

<!-- 今日使用者統計 -->

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

<!-- 詳細連線資料 -->
<div class="container-fluid">
    <table class="table table-bordered table-striped">
        <tr>所有連線內容</tr>
        <tr class="info">
            <th>編號</th>
            <th>姓名</th>
            <th>時間</th>
            <th>來源</th>
        </tr>
        <{foreach from=$content item=content}>
            <tr>
                <td>
                    <{$content.id}>
                </td>
                <td>
                    <{$content.username}>
                </td>
                <td>
                    <{$content.authdate}>
                </td>
                <td>
                    <{$content.clientname}>
                </td>
            </tr>
            <{/foreach}>
    </table>
</div>
<{$bar}>

