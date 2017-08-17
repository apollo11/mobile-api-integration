<?php
namespace App\Http\Traits;

trait HttpResponse
{
    public function errorResponse($data, $title, $code, $statusCode)
    {
        foreach ($data as $error) {
            $value[] =  $error;
        }

        $output = ['error'=>
            [
                'title'=> $title
                , 'code' => $code
                , "status_code" => $statusCode
                , "messages" => $data
            ],
            "success" => false
        ];

        return response($output)->header('status', $statusCode);


    }

    public function ValidUseSuccessResp($status, $success)
    {
        $output = [
            "status_code" => (int) $status,
            "success" => (boolean) $success,
        ];

        return response($output)->header('status', $status);

    }


}