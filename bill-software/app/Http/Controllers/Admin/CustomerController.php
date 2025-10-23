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
        $searchField = request('search_field', 'all');
        $status = request('status'); // 'active' | 'inactive'
        $dateFrom = request('date_from');
        $dateTo = request('date_to');

        $customers = Customer::query()
            ->when($search && trim($search) !== '', function ($query) use ($search, $searchField) {
                $search = trim($search);
                
                if ($searchField === 'all') {
                    // Search across all fields
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('code', 'like', "%{$search}%")
                          ->orWhere('mobile', 'like', "%{$search}%")
                          ->orWhere('telephone_office', 'like', "%{$search}%")
                          ->orWhere('address', 'like', "%{$search}%")
                          ->orWhere('dl_number', 'like', "%{$search}%")
                          ->orWhere('gst_name', 'like', "%{$search}%")
                          ->orWhere('city', 'like', "%{$search}%");
                    });
                } else {
                    // Search in specific field
                    $validFields = ['name', 'code', 'mobile', 'telephone_office', 'address', 'dl_number', 'gst_name'];
                    if (in_array($searchField, $validFields)) {
                        $query->where($searchField, 'like', "%{$search}%");
                    }
                }
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
            ->paginate(10)
            ->withQueryString();

        // AJAX request handling
        if (request()->ajax()) {
            return view('admin.customers.index', compact('customers', 'search', 'searchField', 'status', 'dateFrom', 'dateTo'));
        }

        return view('admin.customers.index', compact('customers', 'search', 'searchField', 'status', 'dateFrom', 'dateTo'));
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
        // Validate required fields only
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:255',
            'pan_number' => 'nullable|string|max:255',
            'gst_name' => 'nullable|string|max:255',
        ]);

        // Prepare data for insertion
        $data = $request->except(['_token', '_method']);
        
        // Set timestamps
        $data['created_date'] = now();
        $data['modified_date'] = now();
        
        Customer::create($data);
        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully');
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
        // Prepare data for update
        $data = $request->except(['_token', '_method']);
        
        // Update timestamp
        $data['modified_date'] = now();
        
        $customer->update($data);
        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully');
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


