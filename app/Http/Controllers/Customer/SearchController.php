<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Offer;
use App\Models\ProjectAgreement;

class SearchController extends Controller
{
    /**
     * 🔍 Advanced Search untuk Customer
     * Menggabungkan MeiliSearch + Eloquent Filter
     */
    public function search(Request $request)
    {
        $keyword    = $request->get('q');
        $status     = $request->get('status');
        $startDate  = $request->get('start_date');
        $endDate    = $request->get('end_date');
        $minBudget  = $request->get('min_budget');
        $maxBudget  = $request->get('max_budget');
        $perPage    = $request->get('per_page', 10);

        /** ----------------------------------------
         * 1️⃣ MeiliSearch Query (Full-text)
         * ---------------------------------------- */
        $projectIds = $keyword
            ? Project::search($keyword)->get()->pluck('id')
            : Project::pluck('id');

        $offerIds = $keyword
            ? Offer::search($keyword)->get()->pluck('id')
            : Offer::pluck('id');

        $agreementIds = $keyword
            ? ProjectAgreement::search($keyword)->get()->pluck('id')
            : ProjectAgreement::pluck('id');

        /** ----------------------------------------
         * 2️⃣ Eloquent Filter (Structured Query)
         * ---------------------------------------- */
        $projects = Project::where('customer_id', Auth::id())
            ->whereIn('id', $projectIds)
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($startDate && $endDate, fn($q) =>
                $q->whereBetween('created_at', [$startDate, $endDate]))
            ->when($minBudget && $maxBudget, fn($q) =>
                $q->whereBetween('budget', [$minBudget, $maxBudget]))
            ->latest()
            ->paginate($perPage);

        $offers = Offer::whereHas('project', fn($p) =>
                $p->where('customer_id', Auth::id())
            )
            ->whereIn('id', $offerIds)
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($startDate && $endDate, fn($q) =>
                $q->whereBetween('created_at', [$startDate, $endDate]))
            ->with('developer', 'project')
            ->latest()
            ->paginate($perPage);

        $agreements = ProjectAgreement::whereHas('project', fn($p) =>
                $p->where('customer_id', Auth::id())
            )
            ->whereIn('id', $agreementIds)
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($startDate && $endDate, fn($q) =>
                $q->whereBetween('created_at', [$startDate, $endDate]))
            ->with('project', 'developer')
            ->latest()
            ->paginate($perPage);

        /** ----------------------------------------
         * 3️⃣ Response JSON
         * ---------------------------------------- */
        return response()->json([
            'status'  => true,
            'query'   => $keyword,
            'filters' => compact('status', 'startDate', 'endDate', 'minBudget', 'maxBudget'),
            'data'    => [
                'projects'   => $projects->items(),
                'offers'     => $offers->items(),
                'agreements' => $agreements->items(),
            ],
            'meta'    => [
                'projects' => [
                    'total'      => $projects->total(),
                    'page'       => $projects->currentPage(),
                    'last_page'  => $projects->lastPage(),
                ],
                'offers' => [
                    'total'      => $offers->total(),
                    'page'       => $offers->currentPage(),
                    'last_page'  => $offers->lastPage(),
                ],
                'agreements' => [
                    'total'      => $agreements->total(),
                    'page'       => $agreements->currentPage(),
                    'last_page'  => $agreements->lastPage(),
                ],
            ]
        ]);
    }
}
