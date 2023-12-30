<?php

namespace App\Http\Services;

use App\Http\Resources\CreditNoteResource;
use App\Models\CreditNote;
use App\Models\User;

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
	* Store Credit Note
	*/ 
	public function store($request)
	{
		$creditNote = new CreditNote;
		$creditNote->user_id = auth()->user()->id;
		
		$saved = $creditNote->save();

		$message = "Credit Note created successfully";

		return [$saved, $message, $creditNote];
	}
}