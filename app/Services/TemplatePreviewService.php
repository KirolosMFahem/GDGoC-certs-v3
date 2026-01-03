<?php

namespace App\Services;

class TemplatePreviewService
{
    /**
     * Generate replacements for template preview.
     *
     * @return array
     */
    public function getReplacements(): array
    {
        return [
            'Recipient_Name' => 'John Doe',
            'Event_Title' => 'Certificate Award Ceremony',
            'Org_Name' => 'GDG on Campus',
            'state' => 'New York',
            'event_type' => 'Workshop',
            'issue_date' => now()->toFormattedDateString(),
            'issuer_name' => 'Jane Smith',
            'unique_id' => '123e4567-e89b-12d3-a456-426614174000',
            // Image placeholders (URLs must be valid for PDF generation, but for preview we can use placeholders)
            'Org_Logo' => 'https://via.placeholder.com/150x150.png?text=Logo',
            'Issuer_Signature' => 'https://via.placeholder.com/200x50.png?text=Signature',
        ];
    }

    /**
     * Apply replacements to the content.
     *
     * @param string $content
     * @return string
     */
    public function applyReplacements(string $content): string
    {
        $replacements = $this->getReplacements();

        foreach ($replacements as $key => $value) {
            $content = str_replace(['{{ $' . $key . ' }}', '{{$' . $key . '}}', '{{ ' . $key . ' }}', '{{' . $key . '}}'], $value, $content);
        }

        return $content;
    }
}
