<?php


class User {


    public function isAdmin() {


        return isset($_SESSION['userRole']) && $_SESSION['userRole'] == 'admin';


    }


    public function name() {


        if(isset($_SESSION['userName'])) {

            return $_SESSION['userName'];

        }

        return 'Guest';

    }




}