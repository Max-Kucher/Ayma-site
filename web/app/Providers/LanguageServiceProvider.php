<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Language;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class LanguageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $locale = Request::getPreferredLanguage(Language::pluck('lang_code')->toArray());
        $language = Language::where('lang_code', $locale)->first();

        if ($language) {
            App::setLocale($language->lang_code);
            session(['current_language_id' => $language->id]);
        } else {
            // Устанавливаем язык по умолчанию, если предпочитаемый язык не поддерживается
            $defaultLanguage = Language::where('is_default', true)->first();
            if ($defaultLanguage) {
                App::setLocale($defaultLanguage->lang_code);
                session(['current_language_id' => $defaultLanguage->id]);
            }
        }
    }
}
