<?php


if (!defined('BOOTSTRAP')) { die('Access denied'); }

$schema['cscart_uvdesk'] = array (
    'permissions' => array ('GET' => 'view_cscart_uvdesk', 'POST' => 'manage_cscart_uvdesk'),
);


return $schema;
