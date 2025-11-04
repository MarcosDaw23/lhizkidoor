<?php
$router->get('adminProfile', 'AdminProfileController@index');
$router->post('adminProfile/updateRegional', 'AdminProfileController@updateRegional');
$router->post('adminProfile/updateSignature', 'AdminProfileController@updateSignature');
?>
