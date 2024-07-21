<?php
namespace app\Helper;
use app\Helper\URLHelper;
include_once 'URLHelper.php';

class TableHelper {


    public static function sort(string $sortKey, string $label, array $data) : string{

        $sort = $data['sort'] ?? null; 
        $direction = $data['dir']  ?? null;
        $icone = "";
        
        if($sort === $sortKey){
            $icone = $direction === 'asc' ? '^' : 'v';
        }

        $url = URLHelper::with_params($data, 
        [
            'sort' => $sortKey, 
            'dir' => $direction === 'asc' ? 'desc' : 'asc'
        ]); 

        return "<a href=\"?$url\">$label $icone</a>"  ;
    }


}
?>