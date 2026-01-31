<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix encoding issues in contacts table
        $contacts = DB::table('contacts')->get();
        
        foreach ($contacts as $contact) {
            $updates = [];
            
            // Fix source field
            if ($contact->source) {
                $fixedSource = $this->fixEncoding($contact->source);
                if ($fixedSource !== $contact->source) {
                    $updates['source'] = $fixedSource;
                }
            }
            
            // Fix statut field
            if ($contact->statut) {
                $fixedStatut = $this->fixEncoding($contact->statut);
                if ($fixedStatut !== $contact->statut) {
                    $updates['statut'] = $fixedStatut;
                }
            }
            
            // Update if there are any changes
            if (!empty($updates)) {
                DB::table('contacts')
                    ->where('id', $contact->id)
                    ->update($updates);
            }
        }
    }

    /**
     * Fix UTF-8 encoding issues
     */
    private function fixEncoding(string $text): string
    {
        // Common encoding fixes
        $replacements = [
            'Ã©vÃ©nement' => 'Événement',
            'Ã©vÃ¨nement' => 'Événement', 
            'Ã‰vÃ©nement' => 'Événement',
            'Ã‰vÃ¨nement' => 'Événement',
            '6agn6' => 'Gagné',
            'GagnÃ©' => 'Gagné',
            'gagnÃ©' => 'gagné',
            'ProspÃ©' => 'Prospé',
            'prospÃ©' => 'prospé',
            'RÃ©fÃ©' => 'Référ',
            'rÃ©fÃ©' => 'référ',
            'CrÃ©Ã©' => 'Créé',
            'crÃ©Ã©' => 'créé',
            'Ã ' => 'à',
            'Ã©' => 'é',
            'Ã¨' => 'è',
            'Ãª' => 'ê',
            'Ã®' => 'î',
            'Ã´' => 'ô',
            'Ã»' => 'û',
            'Ã§' => 'ç',
            'Ã€' => 'À',
            'Ã‰' => 'É',
            'Ãˆ' => 'È',
            'ÃŠ' => 'Ê',
            'ÃŽ' => 'Î',
            'Ã"' => 'Ô',
            'Ã›' => 'Û',
            'Ã‡' => 'Ç',
        ];
        
        $fixed = str_replace(array_keys($replacements), array_values($replacements), $text);
        
        // Try to detect and fix double-encoded UTF-8
        if (mb_detect_encoding($fixed, 'UTF-8', true) === false) {
            $fixed = utf8_encode($fixed);
        }
        
        return $fixed;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback needed for encoding fixes
    }
};
