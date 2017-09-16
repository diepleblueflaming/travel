<?php
/**
 * Created by PhpStorm.
 * user: Administrator
 * Date: 9/14/2016
 * Time: 8:17 PM
 */
    if(isset($message))
    {
        echo "<div id='notification'>";
        echo '<h2>'.$message.'</h2>';
        echo '<h3> Trang Web Tự chuyển hướng sau...<span id="loading"></span></h3>';
        echo "</div>";
    }
?>
<script type="application/javascript">notification()</script>
