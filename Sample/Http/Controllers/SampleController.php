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
        // Kontrak API Spine: bungkus {data: [...]} — konsisten dengan core (ApiResponse::list).
        return response()->json(['data' => SampleItem::orderByDesc('id')->get()]);
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
            'name'        => ['required', 'string', 'max:190'],
            'description' => ['nullable', 'string'],
            'quantity'    => ['nullable', 'integer', 'min:0'],
            'price'       => ['nullable', 'numeric', 'min:0'],
        ]);

        $item = SampleItem::create($validated);

        Log::info('[Sample] item created', ['id' => $item->id, 'name' => $item->name]);

        return response()->json($item, 201);
    }

    /**
     * Update item contoh.
     *
     * @authenticated
     *
     * @urlParam id integer required Item ID. Example: 1
     *
     * @bodyParam name string required Nama item. Example: Item A
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $item = SampleItem::find($id);

        if (! $item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $validated = $request->validate([
            'name'        => ['sometimes', 'string', 'max:190'],
            'description' => ['nullable', 'string'],
            'quantity'    => ['nullable', 'integer', 'min:0'],
            'price'       => ['nullable', 'numeric', 'min:0'],
        ]);

        $item->update($validated);

        Log::info('[Sample] item updated', ['id' => $item->id, 'name' => $item->name]);

        return response()->json($item);
    }

    /**
     * Detail satu item — konten tab 'overview'.
     *
     * @authenticated
     *
     * @urlParam id integer required Item ID. Example: 1
     */
    public function show(int $id): JsonResponse
    {
        $item = SampleItem::find($id);

        if (! $item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json($item);
    }

    /**
     * Activity log untuk satu item — konten tab 'activity'.
     *
     * @authenticated
     *
     * @urlParam id integer required Item ID. Example: 1
     */
    public function activityLogs(int $id): JsonResponse
    {
        if (! SampleItem::find($id)) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        // CONTOH: data statis (di produksi: ActivityLogService + polymorphic subject)
        return response()->json([
            'data' => [
                ['event' => 'item.viewed', 'item_id' => $id, 'at' => now()->toIso8601String()],
            ],
        ]);
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
