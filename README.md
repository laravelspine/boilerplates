# boilerplates

Boilerplate module for laravelspine — contoh implementasi **HOOK** (event listeners)
dan **API** untuk modul Spine, plus kontrak **manifest** untuk frontend (nextjs-spine).

## Isi

`Sample/` — modul nwidart contoh yang mendemonstrasikan:

| Bagian | File | Mendemonstrasikan |
|---|---|---|
| HOOK | `Listeners/LogFileActivity.php` | Mendengarkan event Spine `FileUploading`/`FileUploaded`/`FileDeleting`/`FileDeleted` |
| HOOK | `Listeners/LogSettingChange.php` | Mendengarkan event Spine `SettingUpdated` |
| API | `Http/Controllers/SampleController.php` | CRUD endpoint `/api/v1/sample` |
| Migration | `database/migrations/` | Tabel milik modul, jalan otomatis saat install |
| Manifest | `manifest.php` | Kontrak frontend: `menu[]` (Sidebar) + `widgets[]` (Dashboard) |

## Cara pakai

1. Zip modul:
   ```bash
   cd boilerplates && zip -r Sample.zip Sample -x "*.git*"
   ```
2. Install lewat API Spine (konsumen):
   ```bash
   curl -X POST {base}/api/v1/modules/install \
     -H "Authorization: Bearer {token}" \
     -F "file=@Sample.zip"
   ```
3. Verifikasi:
   - Route: `GET /api/v1/sample` (butuh token)
   - Manifest: `GET /api/v1/modules/Sample/manifest` → `{menu: [...], widgets: [...]}`
   - HOOK: upload file → log berisi `[Sample] file uploaded`

## Kontrak manifest

```php
return [
    'menu' => [
        ['slug' => 'sample', 'label' => 'Sample', 'icon' => '📦',
         'href' => '/sample', 'position' => 90],
    ],
    'widgets' => [
        ['id' => 'sample-items', 'area' => 'right-4',
         'title' => 'Sample Items', 'api' => '/api/v1/sample'],
    ],
];
```

Frontend (nextjs-spine) membaca manifest semua modul aktif → Sidebar dan Dashboard
dirender dari data, bukan hardcode per modul (pola: modul mendaftar, core merender).

## Prasyarat konsumen

- `Modules/` (huruf besar, default nwidart) writable oleh user FPM
- `modules_statuses.json` berisi `{}` dan writable
- composer autoload menyertakan PSR-4 `Modules\\` → `Modules/`
