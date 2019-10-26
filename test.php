<?php
    $contact = array(1, "xk", "lebby", "beijing", "010", "11");
    echo '<table border="1" width="600" align="center">';
    echo '<caption><h1>联系人列表</h1></caption>';
    echo '<tr bgcolor="#dddddd">';
    echo '<th>编号</th><th>姓名</th><th>公司</th><th>地址</th><th>电话</th><th>email</th>';
    echo '</tr><tr>';
    for($i=0; $i<count($contact); $i++){
        echo '<td>'.$contact[$i].'</td>';
    }
    echo '</tr></table>';
?>