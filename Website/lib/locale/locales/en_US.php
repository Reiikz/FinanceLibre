<?php

class Lang {
    
    public $lc = array(

        //HOME
        "%text_moovement%"      => "Transaction",
        "%text_History%"        => "History",
        "%title%"               => "Finance Libre",
        "%MOTTO%"               => "\"Cause I hate spread sheets\"",
        "%text_logout%"         => "Log Out:.",
        "%text_wallets%"        => "Wallets",

        //TRANSACTION TABLE
        "%text_transaction_name%"           => "Subject",
        "%text_transaction_description%"    => "Description",
        "%text_transaction_from%"           => "From:",
        "%text_transaction_to%"             => "To:",
        "%text_transaction_ammout%"         => "Ammount",
        "%text_transaction_date%"           => "Date",

        //LOGIN
        "%text_username%"               => "Username",
        "%text_password%"               => "Password",
        "%text_login%"                  => "Login",
        "%username_not_found%"          => "Username Not Found",
        "%username_password_missmatch%" => "Username and password missmatch",

        //NEW ACCOUNT
        "%text_account_name%"           => "Account name",
        "%text_currency_name%"          => "Currency name",
        "%text_savings_account%"        => "Savings account",
        "%text_alien_account%"          => "Alien account",
        "%text_main_account%"           => "Main account",
        "%text_account_description%"    => "Account description",
        "%save%"                        => "Save",

        //wallets
        "%text_new_account%"    => "New Account",
    );

    public $keys = array(
        "home" => array(
            0 => "%text_moovement%",
            1 => "%text_History%",
            2 => "%title%",
            3 => "%MOTTO%",
            4 => "%text_logout%",
            5 => "%text_wallets%",
        ),

        "transactionTable" => array(
            0 => "%text_transaction_name%",
            1 => "%text_transaction_description%",
            2 => "%text_transaction_from%",
            3 => "%text_transaction_to%",
            4 => "%text_transaction_ammout%",
            5 => "%text_transaction_date%",
        ),

        "login" => array(
            0 => "%text_username%",
            1 => "%text_password%",
            2 => "%text_login%",
            3 => "%username_not_found%",
            4 => "%username_password_missmatch%",
        ),

        "transaction" => array(
            0 => "%text_username%",
            1 => "%text_password%",
            2 => "%text_login%",
            3 => "%username_not_found%",
            4 => "%username_password_missmatch%",
        ),

        "newaccount" => array(
            0 => "%text_account_name%",
            1 => "%text_currency_name%",
            2 => "%text_new_account%",
            3 => "%text_savings_account%",
            4 => "%text_alien_account%",
            5 => "%text_main_account%",
            6 => "%text_account_description%",
            7 => "%save%",
        ),

        "accounts" => array(
            0 => "%text_account_name%",
            1 => "%text_currency_name%",
            2 => "%text_new_account%",
            3 => "%text_savings_account%",
            4 => "%text_alien_account%",
            5 => "%text_main_account%",
            6 => "%text_account_description%",
            7 => "%save%",
        ),
    );
}