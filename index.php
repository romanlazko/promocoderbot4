<?php
/**
 * Created by PhpStorm.
 * User: Irina
 * Date: 04-Oct-18
 * Time: 15:51
 */
$output = json_decode(file_get_contents('php://input'),true);
$text = $output['message']['text'];
file_put_contents('logs.txt', $text);

