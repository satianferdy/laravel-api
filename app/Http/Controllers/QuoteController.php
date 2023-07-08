<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteStoreRequest;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Http\Resources\QuoteResource;


class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return QuoteResource::collection(Quote::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuoteStoreRequest $request)
    {
        //
        return new QuoteResource(Quote::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        return new QuoteResource($quote);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //validate
        $validated = $request->validate([
            'quote' => 'required|string|min:10',
            'author' => 'required|string|min:10',
        ]);
        // if validate success update
        if($validated){
            $quote = Quote::find($id);
            // if data found
            if ($quote) {
                $quote->update($validated);
                return response()->json($quote);
                // if data not found
            } else {
                return response()->json(['message' => 'Quote not found'], 404);
            }
        }



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
