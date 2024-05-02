<?php
#lib/PageTemplate.php

require_once ("Models/Database.php");
class PageTemplate {
    public $PageTitle = "Stefans Webshop";
    public $ContentHead;
    public $ContentBody;

    public $DBContext;

    public function __construct( ) {
        $this->DBContext = new DBContext();
    }
}