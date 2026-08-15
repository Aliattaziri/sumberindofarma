<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminPrincipalController extends Controller
{
    public function index()
    {
        $dir = storage_path('principellogos');
        $files = [];
        if (is_dir($dir)) {
            $items = scandir($dir);
            foreach ($items as $it) {
                if (in_array($it, ['.', '..'])) continue;
                $files[] = $it;
            }
        }

        return view('admin.principals.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $file = $request->file('image');
        $name = time() . '-' . preg_replace('/[^A-Za-z0-9._-]/', '-', $file->getClientOriginalName());
        $dir = storage_path('principellogos');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $file->move($dir, $name);

        return back()->with('success', 'Logo berhasil diunggah.');
    }

    public function destroy($filename)
    {
        $path = storage_path('principellogos/' . $filename);
        if (file_exists($path)) {
            @unlink($path);
            return back()->with('success', 'Logo dihapus.');
        }
        return back()->with('error', 'File tidak ditemukan.');
    }
}
