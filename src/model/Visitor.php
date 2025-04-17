<?php
class Visitor
{

//check on the user if he entered before with the the session key is_counted
    public function __construct()
    {

    }
    public function has_visted_before(): bool
    {
        if (! isset($_SESSION['isCounted'])) {
            $_SESSION['isCounted'] = true;
            return false;
        } else {
            return true;
        }
    }
}
