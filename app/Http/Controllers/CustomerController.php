<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Exception;
use DataTables;

class CustomerController extends Controller
{
    public function index($company_slug)
    {
        return view('admin.customer.index', compact('company_slug'));
    }

    public function getData(Request $request, $company_slug)
    {
        $query = Customer::all();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row) use ($company_slug) {
    $editUrl = route('admin-customers.edit', [
        'company_slug' => $company_slug,
        'admin_customer' => $row->id
    ]);
    $deleteUrl = route('admin-customers.destroy', [
        'company_slug' => $company_slug,
        'admin_customer' => $row->id
    ]);

    return '
        <a href="'.$editUrl.'" class="btn btn-sm btn-primary"><i class="ri-edit-fill"></i></a>
        <button class="btn btn-sm btn-danger sa-warning" data-url="'.$deleteUrl.'">
            <i class="ri-delete-bin-fill"></i>
        </button>
    ';
})

            ->rawColumns(['action'])
            ->make(true);
    }

    public function create($company_slug)
    {
        $users = User::all();
        return view('admin.customer.create', compact('company_slug', 'users'));
    }

    public function store(Request $request, $company_slug)
    {
        $request->validate([
            'customer_name'   => 'required|string|max:255',
            'company_name'    => 'required|string|max:255',
            'email'           => 'required|email|unique:customers,email',
            'phone' => ['required', 'regex:/^[0-9]{10,15}$/'],

           'gst' => ['required', 'regex:/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1})$/'],

            'gst_treatment'   => 'required|string|max:50',
            'place_of_supply' => 'required|string|max:100',
            'state'           => 'required|string|max:100',
            'user_id'         => 'required|exists:users,id',
        ]);

        try {
            $data = $request->all();
            $data['company_code'] = $company_slug;

            Customer::create($data);

            return redirect()->route('admin-customers.index', $company_slug)
                ->with('success', 'Customer created successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to create customer: ' . $e->getMessage());
        }
    }

    public function show($company_slug, $id)
    {
        $customer = Customer::where('company_code', $company_slug)->findOrFail($id);

        return view('admin.customer.show', compact('customer', 'company_slug'));
    }

    public function edit($company_slug, $id)
    {
        $customer = Customer::where('company_code', $company_slug)->findOrFail($id);
        $users = User::all();

        return view('admin.customer.edit', compact('customer', 'company_slug', 'users'));
    }

    public function update($company_slug,Request $request,  $id)
    {
        $customer = Customer::findOrFail($id);

        
         $request->validate([
            'customer_name'   => 'required|string|max:255',
            'company_name'    => 'required|string|max:255',
             'email'           => 'required|email|unique:customers,email,' . $id,
            'phone' => ['required', 'regex:/^[0-9]{10,15}$/'],

           'gst' => ['required', 'regex:/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1})$/'],

            'gst_treatment'   => 'required|string|max:50',
            'place_of_supply' => 'required|string|max:100',
            'state'           => 'required|string|max:100',
            'user_id'         => 'required|exists:users,id',
        ]);

        try {
            $customer->update($request->all());

            return redirect()->route('admin-customers.index', $company_slug)
                ->with('success', 'Customer updated successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update customer: ' . $e->getMessage());
        }
    }

    public function destroy($company_slug, $id)
    {
        $customer = Customer::where('company_code', $company_slug)->findOrFail($id);

        try {
            $customer->delete();

            return redirect()->route('admin-customers.index', $company_slug)
                ->with('success', 'Customer deleted successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete customer: ' . $e->getMessage());
        }
    }
}
