<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ProjectAgreement;
use Illuminate\Support\Facades\Auth;

class AgreementDetailController extends Controller
{
    public function show(ProjectAgreement $agreement)
    {
        // Pastikan customer adalah pemilik project
        abort_unless($agreement->consumer_id === Auth::id(), 403);

        $project = $agreement->project;
        $developer = $agreement->developer;
        $agreement->load(['project', 'developer', 'payments']);

        // Misalnya terms berisi scope of work dalam bentuk array
        $scopeOfWork = $agreement->milestones ?? [];

        // Breakdown biaya — ini bisa kamu ambil dari db atau hardcoded
        $totalCostBreakdown = [
            ['label' => 'Desain UI/UX', 'amount' => 5000000],
            ['label' => 'Pengembangan Mobile App', 'amount' => 12000000],
            ['label' => 'Backend Development', 'amount' => 5000000],
            ['label' => 'Testing & Deployment', 'amount' => 2000000],
            ['label' => 'Dokumentasi', 'amount' => 1000000],
        ];

        return view('payments.offer-detail', compact(
            'agreement',
            'project',
            'developer',
            'scopeOfWork',
            'totalCostBreakdown',
        ));
    }
}
