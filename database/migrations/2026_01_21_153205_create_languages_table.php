<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\LanguageModal as Language;

return new class extends Migration {
    public function up(): void
    {
        $languages = [
            [
                'name' => 'Urdu',
                'iso_639_1' => 'ur',
            ],
            [
                'name' => 'Hindi',
                'iso_639_1' => 'hi',
            ],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(
                ['iso_639_1' => $language['iso_639_1']],
                ['name' => $language['name']]
            );
        }
    }

    public function down(): void
    {
        Language::whereIn('iso_639_1', ['ur', 'hi'])->delete();
    }
};
