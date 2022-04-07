<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\MasterApiController;
use Illuminate\Http\Request;
use App\Models\Cliente;


class ClienteApiController extends MasterApiController
{
    protected $model;
    protected $path = 'clientes';

    public function __construct(Cliente $clientes, Request $request)
    {
        $this->model = $clientes;
        $this->request = $request;
    }

}
