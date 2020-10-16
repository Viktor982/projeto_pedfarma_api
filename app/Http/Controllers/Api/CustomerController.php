<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * @var Customer 
     */
    protected $model;

    public function __construct(Customer $model){
        $this->model = $model;
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
        if(empty($request->name) || empty($request->email) || empty($request->phone)){
            return response()->json("Campos obrigatórios faltando", 202);
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
        $customer = $this->model->find($id);

        if(empty($customer)){
            return response()->json("Cliente não encontrado", 202);
        }

        $customer->update($request->all());
        
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
        $customer = $this->model->find($id);

        if(empty($customer)){
             return response()->json("Cliente não encontrado", 202);
        }

        $customer->delete();

        return response()->json("Ok", 200);
    }
}
