<?php
namespace app\Helper;

class URLHelper {

    public static function with_param(array $data, string $param, $value ): string{
        return http_build_query(array_merge($data, [$param => $value]));
        
    }   

    public static function with_params (array $data, array $params) : string{
        return http_build_query(array_merge($data, $params));
    }


 }




?>