<?php

/*
-- this function get title and return if exeist esle return default
-- no parameter
*/
// function getTitle()
// {
//     global $getTitle;
//     if(isset($getTitle))
//     {
//         return $getTitle;
//     }else
//     {
//         return 'Default';
//     }
// }


/*
-- redirect_Home Function parameter[$thsMsg,$url,$seconds] v1.5
-- $thsMsg = echo Message error in pgae
-- $url = get route to redirect_Home
-- $seconds = seconds Before redirect_Home
 */
function redirect_Home($thsMsg,$url =null , $seconds = 1)
{
    if($url == null)
    {
        $url = 'index.php';
    }elseif($url == 'back')
    {
        if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
        {
            $url = $_SERVER['HTTP_REFERER'];
        }
        else
        {
            $url = 'index.php';
        }
    }
    echo $thsMsg ;
    echo '<div class="alert alert-info"> You Will Be redirect_Home_Home To Home After  ' .  $seconds . '  Se </div>';
    header("refresh:$seconds;url=$url");
    exit;

}
/**
 *  COUNT Number Of Item v1.0
 *  Function To Get Number Of Rows In Table 
 *  $item = to Count 
 *  $table = The Table to choose From 
 * 
 * 
*/

function countRows($item ,$table,$id=null)
{
    global $con;
    if(isset($id))
    {
        $stmt = $con->prepare("SELECT COUNT($item) FROM $table WHERE $item = $id");
    }
    else
    {
        $stmt = $con->prepare("SELECT COUNT($item) FROM $table");
    }

    
    $stmt->execute();
    
    return $stmt->fetchColumn();
}

?>