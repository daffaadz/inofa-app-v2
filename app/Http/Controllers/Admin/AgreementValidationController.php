<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgreementValidationController extends Controller
{
    public function index()
    {
        $agreements = ProjectAgreement::where('status','active')
            ->whereDoesntHave('validations', fn($q) => $q->where('status','approved'))
            ->with(['project','developer','consumer'])
            ->paginate(15);

        return view('admin.agreements.validation', compact('agreements'));
    }

    public function approve($id)
    {
        $agreement = ProjectAgreement::findOrFail($id);

        AgreementValidation::create([
            'project_agreement_id' => $agreement->id,
            'admin_id' => auth()->id(),
            'status' => 'approved',
            'validated_at' => now(),
        ]);

        event(new AgreementValidated($agreement));

        return back()->with('success','Kesepakatan disetujui. Proyek dapat dimulai.');
    }

    public function reject(Request $r, $id)
    {
        $agreement = ProjectAgreement::findOrFail($id);

        AgreementValidation::create([
            'project_agreement_id' => $agreement->id,
            'admin_id' => auth()->id(),
            'status' => 'rejected',
            'notes' => $r->notes,
        ]);

        $agreement->update(['status'=>'revised']);

        return back()->with('warning','Kesepakatan dikembalikan untuk revisi.');
    }
}

