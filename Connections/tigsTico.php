<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_tigsTico = "ticotractors.com";
$database_tigsTico = "tico";
$username_tigsTico = "tico";
$password_tigsTico = "LxTiQ92s";
$tigsTico = mysql_pconnect($hostname_tigsTico, $username_tigsTico, $password_tigsTico) or trigger_error(mysql_error(),E_USER_ERROR); 
?>