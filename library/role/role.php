<?php
	session_start();
	function  set_login($user,$field)
	{
		$_SESSION[$field]=$user;
	}
	
	function is_loged($field)
	{
		if(isset($_SESSION[$field]))
			return $_SESSION[$field];
		return false;
	}
	
	function delete_login($field)
	{
		unset($_SESSION[$field]);
	}
	
	function is_supper_admin()
	{
		if($_SESSION['admin']['level']==1 && $_SESSION['admin']['username']=='admin')
			return true;
		else 
			return FALSE;
	}

    function is_admin(){
        if($_SESSION['admin']['level']==1)
            return true;
        else
            return FALSE;
    }


    function isLogedUser()
    {
        if(!is_loged("user"))
        {
            header("location:".base_url("/"));
        }
    }
?>