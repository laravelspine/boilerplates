<?php

declare(strict_types=1);

namespace Modules\Sample\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Sample\Models\SampleItem;

/**
 * CONTOH API — CRUD sederhana untuk modul Sample.
 *
 * Semua endpoint modul otomatis butuh auth:sanctum karena route grup
 * /api/v1 di core. Modul menambah prefix sendiri ('sample') supaya
 * tidak bentrok dengan route core.
 *
 * @group api/v1/sample
 */
class SampleController extends Controller
{
    /**
     * Daftar item contoh.
     *
     * @authenticated
     *
     * @response scenario=success [{"id":1,"name":"Item A","created_at":"2026-08-31T00:00:00+07:00"}]
     */
    public function index(): JsonResponse
    {
        return response()->json(SampleItem::orderByDesc('id')->get());
    }

    /**
     * Buat item contoh.
     *
     * @authenticated
     *
     * @bodyParam name string required Nama item. Example: Item A
     *
     * @response scenario=success {"id":1,"name":"Item A"}
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:190'],
        ]);

        $item = SampleItem::create($validated);

        Log::info('[Sample] item created', ['id' => $item->id, 'name' => $item->name]);

        return response()->json($item, 201);
    }

    /**
     * Hapus item contoh.
     *
     * @authenticated
     *
     * @urlParam id integer required Item ID. Example: 1
     *
     * @response scenario=success {"message":"Item deleted"}
     */
    public function destroy(int $id): JsonResponse
    {
        $item = SampleItem::find($id);

        if (! $item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted']);
    }
}
