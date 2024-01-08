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
            "invoices" => $invoices,
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
            "user_id" => "required",
            "serial" => "required",
            "discount_type" => "required",
            "date" => "required",
            "reference" => "required",
            "admin_note" => "required",
            "quantity_as" => "required",
            "item" => "required",
            "description" => "required",
            "quantity" => "required",
            "rate" => "required",
            "tax" => "required",
            "amount" => "required",
        ]);

        [$saved, $message, $creditNote] = $this->service->store($request);

        return redirect("credit-notes")->with([
            "success" => $message,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CreditNote  $creditNote
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $creditNote = $this->service->show($id);

        return view("/pages/credit-notes/show")
            ->with([
                "creditNote" => $creditNote,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CreditNote  $creditNote
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        [$creditNote, $users] = $this->service->edit($id);

        return view("/pages/credit-notes/edit")->with([
            "creditNote" => $creditNote,
            "users" => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CreditNote  $creditNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "user_id" => "nullable",
            "serial" => "nullable",
            "discount_type" => "nullable",
            "date" => "nullable",
            "reference" => "nullable",
            "admin_note" => "nullable",
            "quantity_as" => "nullable",
            "item" => "required",
            "description" => "required",
            "quantity" => "required",
            "rate" => "required",
            "tax" => "required",
            "amount" => "required",
        ]);

        [$saved, $message, $creditNote] = $this->service->update($request, $id);

        return redirect("credit-notes/" . $id . "/edit")->with([
            "success" => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CreditNote  $creditNote
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        [$deleted, $message, $creditNote] = $this->service->destroy($id);

        return redirect("/credit-notes")->with([
            "success" => $message,
        ]);
    }
}
