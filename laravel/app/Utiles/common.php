<?php
/**
 * Undocumented function
 * @param string $sort
 * @return false|string
 */
function sort2orderby($sort)
{
    if(empty($sort)) {
        return false;
    }
    
    $sort = explode(',', $sort);
    $orderby='';
    foreach ($sort as $value) {
        $orderby .= substr($value,1);
        $orderby .= $value[0]=='-'?' desc,':',';
    }
    return rtrim($orderby,',');
}
