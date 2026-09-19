<?php

namespace App\Services\WhatsApp;

class WhatsAppService
{
    /**
     * Generate a WhatsApp Click-to-Chat URL.
     *
     * This is the temporary implementation for the demo.
     * Later this service can be replaced with Meta/AiSensy API
     * without changing Job Card, Invoice, Task, etc. logic.
     */
    public function createChatUrl(
        string $phone,
        string $message
    ): string {
        $phone = $this->normalizePhone($phone);

        return 'https://wa.me/' . $phone
            . '?text=' . rawurlencode($message);
    }

    /**
     * Normalize an Indian phone number.
     */
    protected function normalizePhone(string $phone): string
    {
        // Remove spaces, +, -, brackets, etc.
        $phone = preg_replace('/\D/', '', $phone);

        // If it's a 10-digit Indian number, add country code.
        if (strlen($phone) === 10) {
            $phone = '91' . $phone;
        }

        // If already starts with 91, leave it as is.
        return $phone;
    }
}
