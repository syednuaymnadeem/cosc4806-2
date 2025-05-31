<?php

require_once ('user.php');

$user = new User();
$user_list = $user->get_all_users();

echo "<pre>";
print_r($user_list);

?>