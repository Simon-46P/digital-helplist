<?php
require_once('lib/PageTemplate.php');
require_once('vendor/autoload.php');
require_once('Models/Database.php');


# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "EduQ";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}
?>
<p>
<div class="row">

</div>
    

</p>