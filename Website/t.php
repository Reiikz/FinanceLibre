<?php
$lc = array(
    "%text_moovement%"  => "Transaction",
    "%text_History%"    => "History",
    "%title%"           => "Finance Libre",
    "%MOTTO%"           => "\"Cause I hate spread sheets\"",


    "%text_transaction_name%"           => "Subject",
    "%text_transaction_description%"    => "Description",
    "%text_transaction_from%"           => "From:",
    "%text_transaction_to%"             => "To:",
    "%text_transaction_ammout%"         => "Ammount",
    "%text_transaction_date%"           => "Date",
);

foreach($lc as $key => $data){
    echo $key . ":" . $data . "<br/>";
}