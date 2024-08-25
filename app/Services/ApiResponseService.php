<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

class ApiResponseService
{

    /**
     * 
     * Reture Successfull JSON Response.
     * 
     * @param mixed $data : return data in the response
     * @param string Message of the Response
     * @param int $status The HTTP status code
     * @return Illuminate\Http\JsonResponse 
     */
    public static function success($data=null, $message = "Operation Successfull" , $status = 200)
    {
        return response()->json([
            "status" => "success",
            "message" =>trans($message) ,
            "data" => $data,
        ], $status);
    }


        /**
     * 
     * Reture Error JSON Response.
     * 
     * @param mixed $data : return data in the response
     * @param string Message of the Response
     * @param int $status The HTTP status code
     * @return Illuminate\Http\JsonResponse 
     */
    public static function error($data = null , $message = "Operation Failed", $status = 400)
    {
        return response()->json([
            'status' => "error",
            "message" => trans($message),
            "data" => $data,
        ], $status);
    }



    public static function paginated(LengthAwarePaginator $paginator, $message = 'Operation Successful', $status = 200)
    {
        return response()->json([
            "status" => "success",
            "message" => trans($message),
            "data" => $paginator->items(),
            'pagination' => [
                'total'=> $paginator->total(),
                'count'=> $paginator->count(),
                'per_page' => $paginator->perPage(),
                'current_page'=> $paginator->currentPage(),
                'total_page'=>$paginator->lastPage(),
            ],
        ], $status);
    }
}



?>