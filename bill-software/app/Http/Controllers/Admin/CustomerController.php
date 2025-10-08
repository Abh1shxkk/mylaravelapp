<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



class CustomerController extends Controller
{
    public function index()
    {
        $search = request('search');
        $status = request('status'); // 'active' | 'inactive'
        $dateFrom = request('date_from');
        $dateTo = request('date_to');

        $customers = Customer::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%")
                      ->orWhere('mobile', 'like', "%{$search}%");
                });
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('status', $status === 'active' ? 1 : 0);
            })
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->orderByDesc('created_date')
            ->paginate(20)
            ->withQueryString();

        return view('admin.customers.index', compact('customers', 'search', 'status', 'dateFrom', 'dateTo'));
    }

    public function create()
    {
        // Fetch countries from API
        try {
            $apiKey = env('COUNTRY_STATE_CITY_API_KEY');
            $response = Http::withHeaders([
                'X-CSCAPI-KEY' => $apiKey
            ])->get('https://api.countrystatecity.in/v1/countries');

            $countries = $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            $countries = [];
        }

        return view('admin.customers.create', compact('countries'));
    }

    public function store(Request $request)
    {
        // Validate required and unique fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
            'address' => 'required|string',
            'mobile' => 'required|string|max:255|unique:customers,mobile',
            // Optional phones should also be unique if provided
            'telephone_office' => 'nullable|string|max:255|unique:customers,telephone_office',
            'telephone_residence' => 'nullable|string|max:255|unique:customers,telephone_residence',
            'pan_number' => 'required|string|max:255|unique:customers,pan_number',
            'gst_name' => 'required|string|max:255|unique:customers,gst_name',
        ]);

        // Get all data and merge validated fields
        $data = array_merge($request->all(), $validated);
        $data['status'] = $request->boolean('status');
        $data['invoice_export'] = $request->boolean('invoice_export');
        $data['order_required'] = $request->boolean('order_required');
        Customer::create($data);
        return redirect()->route('admin.customers.index')->with('success','Customer created');
    }

    public function show(Customer $customer)
    {
        if (request()->ajax()) {
            return response()->json($customer);
        }
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        // Fetch countries from API
        try {
            $apiKey = env('COUNTRY_STATE_CITY_API_KEY');
            $response = Http::withHeaders([
                'X-CSCAPI-KEY' => $apiKey
            ])->get('https://api.countrystatecity.in/v1/countries');

            $countries = $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            $countries = [];
        }

        return view('admin.customers.edit', compact('customer', 'countries'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->all();
        $data['status'] = $request->boolean('status');
        $data['invoice_export'] = $request->boolean('invoice_export');
        $data['order_required'] = $request->boolean('order_required');
        $customer->update($data);
        return redirect()->route('admin.customers.index')->with('success','Customer updated');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return back()->with('success','Customer deleted');
    }

    private function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'tax_registration' => 'nullable|string|max:255',
            'pin_code' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'telephone_office' => 'nullable|string|max:255',
            'telephone_residence' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'contact_person1' => 'nullable|string|max:255',
            'mobile_contact1' => 'nullable|string|max:255',
            'contact_person2' => 'nullable|string|max:255',
            'mobile_contact2' => 'nullable|string|max:255',
            'fax_number' => 'nullable|string|max:255',
            'opening_balance' => 'nullable|numeric',
            'balance_type' => 'nullable|string|max:255',
            'local_central' => 'nullable|string|max:255',
            'credit_days' => 'nullable|integer',
            'birth_day' => 'nullable|date',
            'status' => 'nullable|boolean',
            'flag' => 'nullable|string|max:255',
            'invoice_export' => 'nullable|boolean',
            'due_list_sequence' => 'nullable|string|max:255',
            'tan_number' => 'nullable|string|max:255',
            'msme_license' => 'nullable|string|max:255',
            'dl_number' => 'nullable|string|max:255',
            'dl_expiry' => 'nullable|date',
            'dl_number1' => 'nullable|string|max:255',
            'food_license' => 'nullable|string|max:255',
            'cst_number' => 'nullable|string|max:255',
            'tin_number' => 'nullable|string|max:255',
            'pan_number' => 'nullable|string|max:255',
            'sales_man_code' => 'nullable|string|max:255',
            'area_code' => 'nullable|string|max:255',
            'route_code' => 'nullable|string|max:255',
            'state_code' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'order_required' => 'nullable|boolean',
            'aadhar_number' => 'nullable|string|max:255',
            'registration_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'day_value' => 'nullable|integer',
            'cst_registration' => 'nullable|string|max:255',
            'gst_name' => 'nullable|string|max:255',
            'state_code_gst' => 'nullable|string|max:255',
            'registration_status' => 'nullable|string|max:255',
        ];
    }

    // API methods for country, state, city dropdowns
    public function getCountries()
    {
        try {
            $apiKey = env('COUNTRY_STATE_CITY_API_KEY');
            $response = Http::withHeaders([
                'X-CSCAPI-KEY' => $apiKey
            ])->get('https://api.countrystatecity.in/v1/countries');

            if ($response->successful()) {
                return response()->json($response->json());
            }
            return response()->json(['error' => 'Failed to fetch countries'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getStates($countryCode)
    {
        try {
            $apiKey = env('COUNTRY_STATE_CITY_API_KEY');
            $response = Http::withHeaders([
                'X-CSCAPI-KEY' => $apiKey
            ])->get("https://api.countrystatecity.in/v1/countries/{$countryCode}/states");

            if ($response->successful()) {
                return response()->json($response->json());
            }
            return response()->json(['error' => 'Failed to fetch states'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getCities($countryCode, $stateCode)
    {
        try {
            $apiKey = env('COUNTRY_STATE_CITY_API_KEY');
            $response = Http::withHeaders([
                'X-CSCAPI-KEY' => $apiKey
            ])->get("https://api.countrystatecity.in/v1/countries/{$countryCode}/states/{$stateCode}/cities");

            if ($response->successful()) {
                return response()->json($response->json());
            }
            return response()->json(['error' => 'Failed to fetch cities'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}


