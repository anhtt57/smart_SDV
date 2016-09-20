<?php

function r_response($data, $result_code = 0, $msg = '')
{
    if (!is_array($data)) {
        $data = [$data];
    }
    return [
        'header' => $result_code,
        'body' => [
            'data' => $data,
            'msg' => $msg,
        ],
    ];
}
function array_sort_asc_by_column(&$arr, $col, $dir = SORT_ASC)
{
    $sort_col = array();
    foreach ($arr as $key => $row) {
        $sort_col[$key] = $row[$col];
    }
    array_multisort($sort_col, $dir, $arr);
}
