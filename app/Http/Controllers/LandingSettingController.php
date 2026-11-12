<?php

namespace App\Http\Controllers;

use App\Models\LandingLayanan;
use App\Models\LandingSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * Pengaturan tampilan landing page.
 * Hanya bisa diakses admin (route dibungkus middleware level:1).
 */
class LandingSettingController extends Controller
{
    private const IMG_DIR = 'img/landing';

    /** Kolom gambar pada landing_setting */
    private const GAMBAR = ['hero_gambar', 'tentang_gambar', 'login_gambar'];

    public function index()
    {
        $landing = LandingSetting::allKeyed();
        $layanan = LandingLayanan::orderBy('urutan')->orderBy('id')->get();

        return view('landing_setting.index', compact('landing', 'layanan'));
    }

    /** Simpan semua teks & gambar (hero, proses, tentang, kontak, dll). */
    public function update(Request $request)
    {
        $keys = array_keys(LandingSetting::DEFAULTS);
        $imageKeys = self::GAMBAR;

        $rules = [];
        foreach ($imageKeys as $k) {
            $rules[$k] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096';
        }
        $rules['hero_overlay'] = 'nullable|integer|min:0|max:90';
        $rules['warna_utama']  = ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'];
        $rules['maps_embed']   = ['nullable', 'regex:/^https:\/\/www\.google\.com\/maps\/embed\?[^\s"\']+$/'];

        foreach (['hero_tombol_link', 'hero_tombol2_link'] as $k) {
            // hanya boleh path internal, #anchor, atau http(s) - blok "javascript:"
            $rules[$k] = ['nullable', 'max:255', 'regex:/^(\/|#|https?:\/\/)/i'];
        }
        foreach (['instagram', 'facebook', 'tiktok'] as $k) {
            $rules[$k] = ['nullable', 'max:255', 'regex:/^https?:\/\//i'];
        }

        $request->validate($rules, [
            'maps_embed.regex' => 'Link peta harus berupa URL embed Google Maps (https://www.google.com/maps/embed?...).',
            'hero_gambar.image'    => 'Foto banner harus berupa gambar (jpg, png, webp).',
            'hero_gambar.max'      => 'Ukuran foto banner maksimal 4 MB.',
            'login_gambar.image'   => 'Foto halaman login harus berupa gambar (jpg, png, webp).',
            'login_gambar.max'     => 'Ukuran foto halaman login maksimal 4 MB.',
            'tentang_gambar.image' => 'Foto tentang kami harus berupa gambar (jpg, png, webp).',
            'tentang_gambar.max'   => 'Ukuran foto tentang kami maksimal 4 MB.',
            'hero_tombol_link.regex'  => 'Link tombol 1 harus diawali /, #, atau http(s)://',
            'hero_tombol2_link.regex' => 'Link tombol 2 harus diawali /, #, atau http(s)://',
            'instagram.regex' => 'Link Instagram harus diawali http:// atau https://',
            'facebook.regex'  => 'Link Facebook harus diawali http:// atau https://',
            'tiktok.regex'    => 'Link TikTok harus diawali http:// atau https://',
        ]);

        $data = [];
        foreach ($keys as $k) {
            if (in_array($k, $imageKeys, true)) {
                continue;
            }
            if ($request->has($k)) {
                $data[$k] = $request->input($k);
            }
        }

        // Upload gambar
        foreach ($imageKeys as $k) {
            if ($request->hasFile($k)) {
                $this->hapusFile(LandingSetting::get($k));
                $data[$k] = $this->simpanFile($request->file($k), $k);
            } elseif ($request->boolean('reset_' . $k)) {
                $this->hapusFile(LandingSetting::get($k));
                $data[$k] = null;
            }
        }

        LandingSetting::setMany($data);

        return redirect()
            ->route('landing_setting.index', ['tab' => $request->input('tab', 'hero')])
            ->with('success', 'Tampilan landing page berhasil disimpan.');
    }

    /* ----------------------------- LAYANAN ----------------------------- */

    public function layananStore(Request $request)
    {
        $data = $this->validateLayanan($request);
        unset($data['foto']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->simpanFile($request->file('foto'), 'layanan');
        }
        $data['urutan'] = $data['urutan'] ?? ((int) LandingLayanan::max('urutan') + 1);
        $data['aktif']  = $request->boolean('aktif');

        LandingLayanan::create($data);

        return redirect()->route('landing_setting.index', ['tab' => 'layanan'])
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function layananUpdate(Request $request, $id)
    {
        $layanan = LandingLayanan::findOrFail($id);
        $data = $this->validateLayanan($request);
        unset($data['foto']);

        if ($request->hasFile('foto')) {
            $this->hapusFile($layanan->foto);
            $data['foto'] = $this->simpanFile($request->file('foto'), 'layanan');
        } elseif ($request->boolean('hapus_foto')) {
            $this->hapusFile($layanan->foto);
            $data['foto'] = null;
        }
        $data['urutan'] = $data['urutan'] ?? $layanan->urutan;
        $data['aktif']  = $request->boolean('aktif');

        $layanan->update($data);

        return redirect()->route('landing_setting.index', ['tab' => 'layanan'])
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    public function layananDestroy($id)
    {
        $layanan = LandingLayanan::findOrFail($id);
        $this->hapusFile($layanan->foto);
        $layanan->delete();

        return redirect()->route('landing_setting.index', ['tab' => 'layanan'])
            ->with('success', 'Layanan berhasil dihapus.');
    }

    /* ----------------------------- HELPER ----------------------------- */

    private function validateLayanan(Request $request): array
    {
        return $request->validate([
            'judul'       => 'required|string|max:100',
            'deskripsi'   => 'nullable|string|max:500',
            'harga_label' => 'nullable|string|max:100',
            'urutan'      => 'nullable|integer|min:0|max:9999',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'judul.required' => 'Judul layanan wajib diisi.',
            'foto.image'     => 'File harus berupa gambar (jpg, png, webp).',
            'foto.max'       => 'Ukuran foto maksimal 4 MB.',
        ]);
    }

    private function simpanFile($file, string $prefix): string
    {
        $dir = public_path(self::IMG_DIR);
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        $nama = $prefix . '-' . date('YmdHis') . '-' . substr(md5(uniqid('', true)), 0, 6)
            . '.' . ($file->extension() ?: 'jpg');   // ekstensi dari ISI file, bukan nama dari klien
        $file->move($dir, $nama);

        return '/' . self::IMG_DIR . '/' . $nama;
    }

    /** Hapus file lama, hanya jika memang berada di folder landing. */
    private function hapusFile(?string $path): void
    {
        if ($path && str_starts_with($path, '/' . self::IMG_DIR . '/')) {
            $full = public_path($path);
            if (File::exists($full)) {
                File::delete($full);
            }
        }
    }
}
