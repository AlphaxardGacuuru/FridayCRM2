<?php

namespace App\Http\Services;

use App\Http\Resources\CreditNoteResource;
use App\Models\CreditNote;
use App\Models\User;
use Carbon\Carbon;

class CreditNoteService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $creditNoteQuery = CreditNote::orderBy("id", "DESC");

        $creditNotes = $creditNoteQuery->paginate(20);

        $creditNotes = CreditNoteResource::collection($creditNotes);

        $totalBilled = 0;

        $totalPaid = 0;

        return [$creditNotes, $totalBilled, $totalPaid];
    }

    /*
     * Create
     */
    public function create()
    {
        $users = User::where("account_type", "normal")->get();

        $invoices = CreditNote::all();

        return [$users, $invoices];
    }

    /*
     * Edit
     */
    public function edit($id)
    {
        $creditNote = CreditNote::find($id);

        $creditNote->dateUnformated = Carbon::parse($creditNote->date)->format("Y-m-d");

        $users = User::where("account_type", "normal")->get();

        return [$creditNote, $users];
    }

    /*
     * Store Credit Note
     */
    public function store($request)
    {
        $creditNote = new CreditNote;
        $creditNote->user_id = $request->user_id;
        $creditNote->serial = $request->serial;
        $creditNote->discount_type = $request->discount_type;
        $creditNote->date = $request->date;
        $creditNote->reference = $request->reference;
        $creditNote->admin_note = $request->admin_note;
        $creditNote->quantity_as = $request->quantity_as;

        $items = [];

        for ($i = 0; $i < count($request->item); $i++) {
            // Populate Items array
            array_push($items, [
                "item" => $request->item[$i],
                "description" => $request->description[$i],
                "quantity" => $request->quantity[$i],
                "rate" => $request->rate[$i],
                "tax" => $request->tax[$i],
                "amount" => $request->amount[$i],
            ]);
        }

        $creditNote->items = $items;

        $saved = $creditNote->save();

        $message = "Credit Note created successfully";

        return [$saved, $message, $creditNote];
    }

    /*
     * Update Credit Note
     */
    public function update($request, $id)
    {
        $creditNote = CreditNote::find($id);

        if ($request->filled("user_id")) {
            $creditNote->user_id = $request->user_id;
        }

        if ($request->filled("serial")) {
            $creditNote->serial = $request->serial;
        }

        if ($request->filled("discount_type")) {
            $creditNote->discount_type = $request->discount_type;
        }

        if ($request->filled("date")) {
            $creditNote->date = $request->date;
        }

        if ($request->filled("reference")) {
            $creditNote->reference = $request->reference;
        }

        if ($request->filled("admin_note")) {
            $creditNote->admin_note = $request->admin_note;
        }

        if ($request->filled("quantity_as")) {
            $creditNote->quantity_as = $request->quantity_as;
        }

        $items = [];

        for ($i = 0; $i < count($request->item); $i++) {
            // Populate Items array
            array_push($items, [
                "item" => $request->item[$i],
                "description" => $request->description[$i],
                "quantity" => $request->quantity[$i],
                "rate" => $request->rate[$i],
                "tax" => $request->tax[$i],
                "amount" => $request->amount[$i],
            ]);
        }

        $creditNote->items = $items;

        $saved = $creditNote->save();

        $message = "Credit Note updated successfully";

        return [$saved, $message, $creditNote];
    }

    /*
     * Delete Credit Note
     */
    public function destroy($id)
    {
        $creditNote = CreditNote::find($id);

        $deleted = $creditNote->delete();

        $message = "Credit Note deleted successfully";

        return [$deleted, $message, $creditNote];
    }
}
