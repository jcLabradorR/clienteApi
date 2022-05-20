<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Commune;
use App\Models\Region;
use App\Http\Requests\CustomerCreateRequest;
use App\Http\Resources\Api\V1\CustomerResource;
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
        $statusAct = "A";

        $customersAct = DB::table('customers')
            ->join('regions', 'regions.id', 'customers.id_reg')
            ->join('communes', 'communes.id', 'customers.id_com')
            ->select('customers.name', 'customers.last_name', 'customers.address', 'regions.description as region', 'communes.description as comuna')
            ->where('customers.status', $statusAct)
            ->paginate();

        if(Customer::count() > 0){
                return response()->json([
                    'data' => $customersAct,
                    'success' => true,
                ], 200);
        }
        
        return response()->json([
            'message' => 'No se encontraron registros',
            'success' => false,
        ], 200);
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

        $customerNew = $customer->save();

        if($customerNew){
            return response()->json([
                'message' => 'Customer creado correctamente',
                'success' => true
            ], 201);
        }
        return response()->json([
            'message' => 'Error to create post',
            'success' => false
        ], 500);
       
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
