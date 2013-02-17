<?php
$expire = 60*60*24*365;
header("Pragma: public");
header("Cache-Control: max-age=".$expire);
header("Expires: ".gmdate('D, d M Y H:i:s', time() + $expire)." GMT");
?>
<script scr="//connect.facebook.net/en_US/all.js"></script>