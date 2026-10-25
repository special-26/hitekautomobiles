<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDocument;
use Illuminate\Support\Facades\Storage;

class EmployeeDocumentController extends Controller
{
    public function download(EmployeeDocument $document)
    {
        abort_unless(
            auth()->user()->can('employees.view'),
            403
        );

        abort_unless(
            Storage::disk('local')->exists($document->file_path),
            404
        );

        return Storage::disk('local')->download(
            $document->file_path,
            $document->original_name
        );
    }
}
