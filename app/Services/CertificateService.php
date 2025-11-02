<?php

namespace App\Services;

use App\Models\Certificate;
use Illuminate\Support\Facades\App;

class CertificateService
{
    /**
     * Generate a PDF certificate from a template and certificate data.
     */
    public function generate(Certificate $certificate): string
    {
        // Get the template
        $template = $certificate->certificateTemplate;

        if (! $template) {
            throw new \Exception('Certificate template not found');
        }

        // Get the template content
        $content = $template->content;

        // Create an array of key-value pairs for replacement
        $replacements = [
            '{Recipient_Name}' => $certificate->recipient_name,
            '{Event_Title}' => $certificate->event_title,
            '{Org_Name}' => $certificate->org_name,
            '{state}' => $certificate->state,
            '{event_type}' => $certificate->event_type,
            '{issue_date}' => $certificate->issue_date->toFormattedDateString(),
            '{issuer_name}' => $certificate->issuer_name,
            '{unique_id}' => $certificate->unique_id,
        ];

        // Replace variables in content
        $html = str_replace(array_keys($replacements), array_values($replacements), $content);

        // Generate the PDF
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');

        // Return the PDF binary
        return $pdf->output();
    }
}
