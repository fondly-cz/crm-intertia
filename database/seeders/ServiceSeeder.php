<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing services
        Service::query()->delete();

        $services = [
            1 => [
                'name' => 'Vytvoření statických webových stránek',
                'is_required' => true,
                'payment_period' => 'once',
                'cost' => 12000,
                'days' => 14,
                'description' => 'Stránky budou vytvořeny na základě dodaných podkladů. Statické stránky jsou bez redakčního systému.',
            ],
            2 => [
                'name' => 'Registrace/prodloužení domény',
                'is_required' => true,
                'payment_period' => 'yearly',
                'cost' => 300,
                'days' => 0,
                'description' => 'fyziokozakova.cz',
            ],
            3 => [
                'name' => 'Pronájem domény .cz na rok',
                'is_required' => true,
                'parent_id' => 2,
                'payment_period' => 'yearly',
                'cost' => 200,
                'days' => 0,
                'description' => null,
            ],
            4 => [
                'name' => 'Registrace/prodloužení domény',
                'is_required' => false,
                'payment_period' => 'yearly',
                'cost' => 300,
                'days' => 0,
                'description' => 'fyzio-kozakova.cz – doporučujeme dokoupit, kdyby náhodou konkurence chtěla parazitovat na doméně.',
            ],
            5 => [
                'name' => 'Pronájem domény .cz na rok',
                'is_required' => true,
                'parent_id' => 4,
                'payment_period' => 'yearly',
                'cost' => 200,
                'days' => 0,
                'description' => null,
            ],
            6 => [
                'name' => 'Přesměrování domény',
                'is_required' => true,
                'parent_id' => 4,
                'payment_period' => 'once',
                'cost' => 300,
                'days' => 0,
                'description' => 'Doménu fyzio-kozakova.cz přesměrujeme na verzi bez pomlčky',
            ],
            7 => [
                'name' => 'Konfigurace záznamu na Mapy.cz a Firmy.cz',
                'is_required' => false,
                'payment_period' => 'once',
                'cost' => 900,
                'days' => 1,
                'description' => 'Nahrání fotek, správné kontakty, místo, otevírací doba',
            ],
            8 => [
                'name' => 'Konfigurace záznamu na Google Mapách',
                'is_required' => false,
                'payment_period' => 'once',
                'cost' => 600,
                'days' => 1,
                'description' => 'Nahrání fotek, správné kontakty, místo, otevírací doba',
            ],
            9 => [
                'name' => 'Založení emailového serveru na EmailProfi',
                'is_required' => false,
                'payment_period' => 'once',
                'cost' => 600,
                'days' => 0,
                'description' => null,
            ],
            10 => [
                'name' => 'Vytvoření emailové schránky v EmailProfi',
                'is_required' => false,
                'parent_id' => 9,
                'payment_period' => 'once',
                'cost' => 300,
                'days' => 0,
                'description' => 'info@fyziokozakova.cz',
            ],
            11 => [
                'name' => 'Hosting k webovým stránkám',
                'is_required' => true,
                'payment_period' => 'měsíčně',
                'cost' => 150,
                'days' => 0,
                'description' => 'Stránky jsou umístěny na zabezpečeném hostingu, kde probíhá zálohování každý den.',
            ],
            12 => [
                'name' => 'Konfigurace Facebook stránky',
                'is_required' => false,
                'payment_period' => 'once',
                'cost' => 1200,
                'days' => 1,
                'description' => 'Doplnění fotek, grafické zpracování',
            ],
            13 => [
                'name' => 'Konfigurace profilu na Instagramu',
                'is_required' => false,
                'payment_period' => 'once',
                'cost' => 1200,
                'days' => 1,
                'description' => 'Doplnění fotek, grafické zpracování, textové po',
            ],
            14 => [
                'name' => 'Propojení Facebook a Instagram',
                'is_required' => false,
                'payment_period' => 'once',
                'cost' => 600,
                'days' => 1,
                'description' => 'Vkládání fotek na Instagram se automaticky bude propisovat na Facebook a celkově budou oba profily vzájemně propojené.',
            ],
        ];

        $created = [];

        foreach ($services as $index => $data) {
            $parentId = null;
            if (isset($data['parent_id']) && isset($created[$data['parent_id']])) {
                $parentId = $created[$data['parent_id']]->id;
            }

            // Note: USER asked "popis tam nevkládej" for the DATABASE (Services table),
            // but wants them in the CALCULATION later.
            // Wait, "popis tam nevkládej" usually means the 'description' field in the 'services' table.

            $paymentPeriod = $data['payment_period'];
            if ($paymentPeriod === 'měsíčně') {
                $paymentPeriod = 'monthly';
            } elseif ($paymentPeriod === 'ročně') {
                $paymentPeriod = 'yearly';
            } elseif ($paymentPeriod === 'jednorázově') {
                $paymentPeriod = 'once';
            }

            $created[$index] = Service::create([
                'name' => $data['name'],
                'parent_id' => $parentId,
                'category' => 'Fyzioterapie',
                'description' => '', // USER asked NOT to include description here
                'cost' => $data['cost'],
                'margin' => 0,
                'days' => $data['days'],
                'payment_period' => $paymentPeriod,
                'is_required' => $data['is_required'],
                'is_active' => true,
            ]);
        }
    }
}
