<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\MasterApiController;
use Illuminate\Http\Request;
use App\Models\Fornecedor;


class FornecedorApiController extends MasterApiController
{
    protected $model;
    protected $path = '';
    protected $upload = '';
    protected $widht = 177;
    protected $height = 236;
    protected $totalPage = 20;


    public function __construct(Fornecedor $fornecedor, Request $request)
    {
        $this->model = $fornecedor;
        $this->request = $request;
    }
}
