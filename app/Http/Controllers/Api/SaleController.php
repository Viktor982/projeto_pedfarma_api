<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Provider;

class SaleController extends Controller
{
    /**
     * @var Sale 
     */
    protected $model;

    /**
     * @var Customer 
     */
    protected $customerModel;

    /**
     * @var Provider 
     */
    protected $providerModel;

    public function __construct(Sale $model, Customer $customerModel, Provider $providerModel){
        $this->model = $model;
        $this->customerModel = $customerModel;
        $this->providerModel = $providerModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->model->where('user_id',auth('api')->user()->id)->get());
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        if(empty($request->unitary_value) || empty($request->quantity) || empty($request->amount) || empty($request->customer_id) || empty($request->provider_id)){
            return response()->json("Campos obrigatórios faltando", 202);
        }

        if(empty($this->customerModel->find($request->customer_id))){
            return response()->json("Cliente não encontrado", 202);
        }

        if(empty($this->providerModel->find($request->provider_id))){
            return response()->json("Fornecedor não encontrado", 202);
        }

        $this->model->create(array_merge($request->all(), ['user_id' => auth('api')->user()->id]));

        return response()->json('Ok', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->model->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sale = $this->model->find($id);

        if(empty($sale)){
            return response()->json("Venda não encontrada", 202);
        }

        $sale->update($request->all());

        return response()->json('Ok', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = $this->model->find($id);

        if(empty($sale)){
             return response()->json("Venda não encontrada", 202);
        }

        $sale->delete();

        return response()->json("Ok", 200);
    }
}
