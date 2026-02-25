<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'UX/UI Design', 'category' => 'design', 'description' => 'Kompletní grafický návrh webu včetně wireframů, barevného schématu a typografie.', 'cost' => 8000, 'margin' => 40, 'days' => 7, 'icon' => '🎨'],
            ['name' => 'Responzivní design', 'category' => 'design', 'description' => 'Přizpůsobení webu pro mobily, tablety a všechny velikosti obrazovek.', 'cost' => 4000, 'margin' => 35, 'days' => 3, 'icon' => '📱'],
            ['name' => 'Kódování front-endu', 'category' => 'vyvoj', 'description' => 'HTML/CSS/JS implementace designu s moderními technologiemi.', 'cost' => 12000, 'margin' => 30, 'days' => 10, 'icon' => '💻'],
            ['name' => 'WordPress / CMS', 'category' => 'vyvoj', 'description' => 'Napojení na redakční systém pro snadnou správu obsahu.', 'cost' => 6000, 'margin' => 35, 'days' => 5, 'icon' => '⚙️'],
            ['name' => 'E-shop (WooCommerce)', 'category' => 'vyvoj', 'description' => 'Kompletní e-shopové řešení s košíkem, platbami a správou objednávek.', 'cost' => 20000, 'margin' => 40, 'days' => 14, 'icon' => '🛒'],
            ['name' => 'SEO optimalizace', 'category' => 'marketing', 'description' => 'On-page SEO, meta tagy, sitemap, rychlost načítání a základní optimalizace.', 'cost' => 3000, 'margin' => 45, 'days' => 3, 'icon' => '🔍'],
            ['name' => 'Copywriting', 'category' => 'obsah', 'description' => 'Profesionální texty pro web – hlavní stránka, o nás, služby, kontakt.', 'cost' => 4000, 'margin' => 50, 'days' => 4, 'icon' => '✍️'],
            ['name' => 'Logo a branding', 'category' => 'design', 'description' => 'Tvorba loga, vizuální identity a brand manuálu.', 'cost' => 6000, 'margin' => 45, 'days' => 5, 'icon' => '✨'],
            ['name' => 'Hosting a doména', 'category' => 'hosting', 'description' => 'Registrace domény a nastavení hostingu na první rok.', 'cost' => 1500, 'margin' => 30, 'days' => 1, 'icon' => '🖥️'],
            ['name' => 'Kontaktní formulář', 'category' => 'vyvoj', 'description' => 'Funkční kontaktní formulář s odesíláním na e-mail a ochranou proti spamu.', 'cost' => 2000, 'margin' => 35, 'days' => 2, 'icon' => '📬'],
            ['name' => 'Google Analytics', 'category' => 'marketing', 'description' => 'Integrace Google Analytics 4 a nastavení základního trackingu.', 'cost' => 1500, 'margin' => 40, 'days' => 1, 'icon' => '📊'],
            ['name' => 'Údržba a podpora', 'category' => 'hosting', 'description' => 'Měsíční údržba webu, aktualizace, zálohy a technická podpora.', 'cost' => 2000, 'margin' => 50, 'days' => 0, 'icon' => '🛡️'],
        ];

        foreach ($services as $service) {
            \App\Models\Service::create($service);
        }
    }
}
