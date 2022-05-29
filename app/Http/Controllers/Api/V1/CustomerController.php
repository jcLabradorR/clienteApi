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
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::debug('Mensaje de prueba');

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
        ], 204);
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
            'message' => 'Error Al crear customer',
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
        try {
            $customers = Customer::findOrFail($request->dni);
        $dni = $customers->dni;
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
            'Dni' => $dni,
            'Nombre completo' => $name. ' '. $lastName,
            'email' => $customers->email,
            'direccion' => $customers->address,
            'region' =>  $regionCust,
            'comuna' => $communeCust,
            'success' => true
        ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'usuario no encontrado',
                'success' => false
            ], 404);
        }                     
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

        if(!$customer){
            return response()->json([
                'message' => 'Registro no existe',
                'success' => false
            ], 404);
        }

        return response()->json([
            'message' => 'Customer borrado correctamente',
            'success' => true
        ], 200);
    }
}
