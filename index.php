<?php
/**
 * Created by PhpStorm.
 * User: Irina
 * Date: 04-Oct-18
 * Time: 15:51
 */
$output = file_get_contents('pup://input');

file_put_contents('logs.txt', $output);
