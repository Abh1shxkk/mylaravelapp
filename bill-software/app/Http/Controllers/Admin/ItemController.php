<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(){ $search = request('search'); $status = request('status'); $dateFrom = request('date_from'); $dateTo = request('date_to'); $items = Item::query()->when($search, function($query) use ($search){ $query->where(function($q) use ($search){ $q->where('name','like',"%{$search}%")->orWhere('code','like',"%{$search}%")->orWhere('Barcode','like',"%{$search}%"); }); })->when($status!==null && $status!=='', function($query) use ($status){ $query->where('status', $status==='active'?1:0); })->when($dateFrom, function($query) use ($dateFrom){ $query->whereDate('created_at','>=',$dateFrom); })->when($dateTo, function($query) use ($dateTo){ $query->whereDate('created_at','<=',$dateTo); })->orderByDesc('id')->paginate(20)->withQueryString(); return view('admin.items.index', compact('items','search','status','dateFrom','dateTo')); }
    public function create(){ return view('admin.items.create'); }
    public function store(Request $request){ $data = $request->all(); $data = $this->bools($request,$data); Item::create($data); return redirect()->route('admin.items.index')->with('success','Item created'); }
    public function show(Item $item){ return view('admin.items.show', compact('item')); }
    public function edit(Item $item){ return view('admin.items.edit', compact('item')); }
    public function update(Request $request, Item $item){ $data = $request->all(); $data = $this->bools($request,$data); $item->update($data); return redirect()->route('admin.items.index')->with('success','Item updated'); }
    public function destroy(Item $item){ $item->delete(); return back()->with('success','Item deleted'); }

    private function bools(Request $r, array $data): array
    {
        foreach(['status','CommonItem','PresReq','Inclusive','TaxonMrp','VATonSrate','Exon','DisContinue','LockScm','RateLock','LockBilling','SameBatchCost'] as $b){ $data[$b] = $r->boolean($b); }
        return $data;
    }

    private function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
            'Barcode' => 'nullable|string|max:100',
            'Compcode' => 'nullable|string|max:100',
            'Compname' => 'nullable|string|max:255',
            'Pack' => 'nullable|string|max:50',
            'Unit' => 'nullable|string|max:50',
            'Location' => 'nullable|string|max:100',
            // Add validation rules for all new fields
            'MfgBy' => 'nullable|string|max:255',
            'Division' => 'nullable|string|max:50',
            'BoxQty' => 'nullable|integer',
            'CaseQty' => 'nullable|integer',
            'Schedule' => 'nullable|string|max:50',
            'MinLevel' => 'nullable|integer',
            'MaxLevel' => 'nullable|integer',
            'Flag' => 'nullable|string|max:100',
            'Srate' => 'nullable|numeric',
            'Mrp' => 'nullable|numeric',
            'Net' => 'nullable|numeric',
            'Wsrate' => 'nullable|numeric',
            'SplRate' => 'nullable|numeric',
            'MinGP' => 'nullable|numeric',
            'Commodity' => 'nullable|string|max:255',
            'Scheme' => 'nullable|integer',
            'Prate' => 'nullable|numeric',
            'Cost' => 'nullable|numeric',
            'PurScheme' => 'nullable|integer',
            'NR' => 'nullable|numeric',
            'HSNCode' => 'nullable|string|max:100',
            'CGST' => 'nullable|numeric',
            'SGST' => 'nullable|numeric',
            'IGST' => 'nullable|numeric',
            'Cess' => 'nullable|numeric',
            'VAT' => 'nullable|numeric',
            'Expiry' => 'nullable|date',
            'Generic' => 'nullable|string|max:50',
            'Stax' => 'nullable|numeric',
            'FixedDis' => 'nullable|numeric',
            'Category' => 'nullable|string|max:50',
            'MaxInvQty' => 'nullable|integer',
            'Weight' => 'nullable|numeric',
            'Volume' => 'nullable|numeric',
            'Lock' => 'nullable|string|max:50',
            'BarCodeFlag' => 'nullable|string|max:10',
            'DetQty' => 'nullable|string|max:10',
            'CompNameBC' => 'nullable|string|max:10',
            'DPCItem' => 'nullable|string|max:10',
            'LockSale' => 'nullable|string|max:10',
            'CommodityClass' => 'nullable|string|max:255',
            'CurrentScheme' => 'nullable|string|max:255',
            'CategoryClass' => 'nullable|string|max:50',
        ];
    }
}


