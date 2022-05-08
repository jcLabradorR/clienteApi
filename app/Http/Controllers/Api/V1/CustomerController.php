<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Customer;
use App\Models\Commune;
use App\Models\Region;
use App\Http\Requests\CustomerCreateRequest;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return $customers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerCreateRequest $request)
    {
        $customer = new Customer();
        $customer->dni = $request->dni;
        $customer->id_reg = $request->id_reg;
        $customer->id_com = $request->id_com;
        $customer->email = $request->email;
        $customer->name = $request->name;
        $customer->last_name = $request->last_name;
        $customer->address = $request->address;
        $customer->date_reg = $request->date_reg;
        $customer->status = $request->status;

        $customer->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $customers = Customer::find($request->dni);
        $name = $customers->name;
        $lastName = $customers->last_name;
        $regionCustomers = $customers->id_reg;
        $communesCustomers = $customers->id_com;
        
        $region = DB::table('regions')
            ->join('customers', 'regions.id', 'customers.id_reg')
            ->select('regions.description')
            ->where('regions.id', $regionCustomers)
            ->get();
        $regionCust = $region->first();

        $commune = DB::table('communes')
            ->join('customers', 'communes.id', 'customers.id_com')
            ->select('communes.description')
            ->where('communes.id', $communesCustomers)
            ->get();
        $communeCust = $commune->first();

        return response()->json([
            'Dni' => $customers->dni,
            'Nombre completo' => $name. ' '. $lastName,
            'email' => $customers->email,
            'direccion' => $customers->address,
            'region' =>  $regionCust,
            'comuna' => $communeCust
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $customer = Customer::destroy($request->dni);
        return $customer;
    }
}
