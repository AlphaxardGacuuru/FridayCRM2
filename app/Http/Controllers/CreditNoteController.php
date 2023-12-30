<?php

namespace App\Http\Controllers;

use App\Http\Services\CreditNoteService;
use App\Models\CreditNote;
use Illuminate\Http\Request;

class CreditNoteController extends Controller
{
	public function __construct(protected CreditNoteService $service)
	{
		// 
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        [$creditNotes, $totalBilled, $totalPaid] = $this->service->index();

        return view("/pages/credit-notes/index")
            ->with([
                "creditNotes" => $creditNotes,
                "totalBilled" => $totalBilled,
                "totalPaid" => $totalPaid,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		[$users, $invoices] = $this->service->create();

		return view("/pages/credit-notes/create")->with([
			"users" => $users,
			"invoices" => $invoices
		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			""
		]);

		[$saved, $message, $creditNote] = $this->service->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CreditNote  $creditNote
     * @return \Illuminate\Http\Response
     */
    public function show(CreditNote $creditNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CreditNote  $creditNote
     * @return \Illuminate\Http\Response
     */
    public function edit(CreditNote $creditNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CreditNote  $creditNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CreditNote $creditNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CreditNote  $creditNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(CreditNote $creditNote)
    {
        //
    }
}
