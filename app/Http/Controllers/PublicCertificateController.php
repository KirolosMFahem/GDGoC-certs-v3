<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Services\CertificateService;
use Illuminate\Http\Request;

class PublicCertificateController extends Controller
{
    /**
     * Display the validation form.
     */
    public function index()
    {
        return view('validate.index');
    }

    /**
     * Validate and redirect to certificate show page.
     */
    public function validate(Request $request)
    {
        $request->validate([
            'unique_id' => 'required|string',
        ]);

        return redirect()->route('public.certificate.show', ['unique_id' => $request->unique_id]);
    }

    /**
     * Display the specified certificate.
     */
    public function show($unique_id)
    {
        $certificate = Certificate::where('unique_id', $unique_id)->firstOrFail();

        return view('validate.show', compact('certificate'));
    }

    /**
     * Download the certificate PDF.
     */
    public function download(CertificateService $certificateService, $unique_id)
    {
        $certificate = Certificate::where('unique_id', $unique_id)
            ->where('status', 'issued')
            ->firstOrFail();

        $pdfData = $certificateService->generate($certificate);

        return response($pdfData)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="certificate.pdf"');
    }
}
