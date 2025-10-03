<?php

class User
{
    public function isAdmin()
    {
        return isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['admin', 'editor']);
    }
    public function isLogged()
    {
        return isset($_SESSION['logged_in']);
    }

    public function isEditorClosed()
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin';
    }
    public function userName()
    {
        if (isset($_SESSION['user_name'])) {
            return   $_SESSION['user_name'];
        }
        return 'Guest';
    }
}
