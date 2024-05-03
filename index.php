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
<img src="img/halfcircle.svg" alt="circle" class="bg-img">
<img src="img/halfcircletop.svg" alt="circle" class="bg-img-top">
    <div class="row-1">
        <div class="info-container">
            <h1>Your easy to use <br> digital helplist</h1>
            <p>Streamlined administration and communication in one place. <br> <b>EduQ</b> - the comprehensive solution for school efficiency and effectiveness.</p>
                <div class="button-container">
                    <a href="/BookDemo.php"><button class="filled-btn">Book Demo</button></a>
                    <a href="/Solutions.php"><button class="hollow-btn">Our Solutions</button></a>
                </div>

                <div class="costumer-container">
                    <p><i class="fa-solid fa-circle-question"></i><b> Already a customer?</b> <a href="/CreateQueue.php">Get started!</a></p>
                   
                </div>
        </div>

        <div class="img-container"><img src="img/screen_v2.png" alt="example" class="example-img"></div>
    </div>

    <div class="row-2">
    <div class="img-container">
        <img src="img/helpimage.jpg" alt="Help Image" class="help-img">
    </div>
    <div class="functionality-container">
        <h1>Accessible Everywhere</h1>
        <p>EduQ is meticulously designed to streamline school operations across all demographics, fostering inclusivity and efficiency. It provides a secure foundation for seamless management.</p>
        <p><b>Highlighted Features:</b></p>
            <li><i class="fa-solid fa-circle-check"></i> Attendance Tracking</li>
            <li><i class="fa-solid fa-circle-check"></i> Communication Hub</li>
            <li><i class="fa-solid fa-circle-check"></i> Assignment Submission</li>
            <li><i class="fa-solid fa-circle-check"></i> Resource Sharing</li>
            <li><i class="fa-solid fa-circle-check"></i> Customizable Dashboards</li>
            <li><i class="fa-solid fa-circle-check"></i> Queue Management</li>
            <li><i class="fa-solid fa-circle-check"></i> Assessment Tools</li>
    </div>
</div>


    

