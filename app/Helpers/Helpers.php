<?php


/**
 * @param $data
 * @return false|string
 */
function jsonEncode($data) {
    return json_encode($data);
}


/**
 * @param $data
 * @return mixed
 */
function jsonDecode($data) {
    return json_decode($data);
}