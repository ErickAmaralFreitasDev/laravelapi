<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Invoice; 
use Illuminate\Http\Request;
use App\Http\Resources\V1\InvoiceResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\HttpResponses; 

class InvoiceController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth:sanctum', 'ability:invoice-store, user-update')->only(['store', 'update']);
    }

    public function index(Request $request)
    {
        return (new Invoice())->filter($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {

    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!auth()->user()->tokenCan('invoice-store')) {
            return $this->error('You do not have permission to create invoices', 403);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required|max:1',
            'paid' => 'required|numeric|between:0,1',
            'payment_date' => 'nullable',
            'value' => 'required|numeric|between:1,9999.99',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $created = Invoice::create($validator->validated());

        if ($created) {
            return $this->response('Invoice created successfully', 200, new InvoiceResource($created->load('user')));
        }
            return $this->error('Failed to create invoice', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice->load('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {

    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        if(!auth()->user()->tokenCan('invoice-update')) {
            return $this->error('You do not have permission to update invoices', 403);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required|max:1|in:' . implode(',', ['B', 'C', 'P']),
            'paid' => 'required|numeric|between:0,1',
            'value' => 'required|numeric|between:1,9999.99',
            'payment_date' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $validated = $validator->validated();

        $updated = $invoice->update([
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'paid' => $validated['paid'],
            'value' => $validated['value'],
            'payment_date' => $validated['paid'] ? $validated['payment_date'] : null,
        ]);

        if ($updated) {
            return $this->response('Invoice updated successfully', 200, new InvoiceResource($invoice->load('user')));
        }
            return $this->error('Failed to update invoice', 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $deleted = $invoice->delete();

        if ($deleted) {
            return $this->response('Invoice deleted successfully', 200);
        }
        return $this->error('Failed to delete invoice', 400);
    }
}
