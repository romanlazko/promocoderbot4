<?php
/**
 * Created by PhpStorm.
 * User: Irina
 * Date: 04-Oct-18
 * Time: 15:51
 */
$output = ison_decode(file_get_contents('php://input'),true);
$text = $output['message']['text'];
file_put_contents('logs.txt', $output);

