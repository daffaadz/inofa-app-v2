<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\ProjectAgreement;
use Illuminate\Support\Facades\Auth;

class AgreementController extends Controller
{
    public function index()
    {
        $agreements = ProjectAgreement::where('developer_id', Auth::id())
            ->with(['project', 'consumer'])
            ->latest()
            ->paginate(10);

        return view('developer.agreements.index', compact('agreements'));
    }

    public function show(ProjectAgreement $agreement)
    {
        $this->authorize('view', $agreement);
        $agreement->load(['project', 'consumer', 'payments']);
        return view('developer.agreements.show', compact('agreement'));
    }
}