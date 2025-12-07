<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ComplaintController extends Controller
{
    /**
     * Store a newly created complaint in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'description' => 'required|string|min:10',
                'terms_accepted' => 'required|accepted',
            ], [
                'description.required' => 'Deskripsi pengaduan harus diisi.',
                'description.min' => 'Deskripsi pengaduan minimal 10 karakter.',
                'terms_accepted.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
            ]);

            // Create complaint
            $complaint = Complaint::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'description' => $request->description,
                'terms_accepted' => true,
                'status' => 'in_progress',
            ]);

            return Response::json([
                'success' => true,
                'message' => 'Pengaduan Anda berhasil dikirim. Admin akan segera meninjau pengaduan Anda.',
                'complaint' => $complaint,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return Response::json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim pengaduan. Silakan coba lagi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a listing of the user's complaints.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $complaints = Complaint::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

            return Response::json([
                'success' => true,
                'complaints' => $complaints,
            ], 200);

        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data pengaduan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified complaint.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $complaint = Complaint::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            return Response::json([
                'success' => true,
                'complaint' => $complaint,
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return Response::json([
                'success' => false,
                'message' => 'Pengaduan tidak ditemukan.',
            ], 404);

        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data pengaduan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
