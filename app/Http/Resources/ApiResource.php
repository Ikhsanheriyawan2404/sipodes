<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    public $status;
    public $message;

    public function __construct($code, $status, $message, $resource = [])
    {
        parent::__construct($resource);
        $this->code = $code;
        $this->status = $status;
        $this->message = $message;
    }

    public function toArray($request)
    {
        return [
            'meta' => [
                'code'     => $this->code,
                'status'   => $this->status,
                'message'  => $this->message,
            ],
            'data'     => $this->resource
        ];
    }
}
