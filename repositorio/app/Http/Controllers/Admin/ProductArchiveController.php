<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductArchiveController extends Controller
{
    public function removeArchive(Request $request)
    {
        $archiveName = $request->get('archiveName');

        //Remove dos arquivos
        if(Storage::disk('public')->exists($archiveName)) {
            Storage::disk('public')->delete($archiveName);
        }

        //Remove a arquivo do banco
        $removeArchive = ProductArchive::where('file', $archiveName);

        $productId   = $removeArchive->first()->product_id;

        $removeArchive->delete();

        flash('Arquivo removido com sucesso!')->success();
        return redirect()->route('admin.products.edit', ['product' => $productId]);
    }
}
