<?php

namespace App\Console\Commands;

use App\Models\FaultCode;
use App\Services\GeminiService;
use Illuminate\Console\Command;

class GenerateFaultCodes extends Command
{
    protected $signature = 'faults:generate {--make=}';
    protected $description = 'Generate fault codes using Gemini AI';

    public function handle()
    {
        $make = $this->option('make');
        if (!$make) { $this->error('Use --make=Toyota'); return; }

        $this->info("Generating for {$make}...");
        $gemini = new GeminiService();
        
        $codes = [
            'P0201','P0202','P0203','P0204','P0205','P0206','P0207','P0208','P0209','P0210',
            'P0211','P0212','P0213','P0214','P0215','P0216','P0218','P0219','P0220','P0221',
            'P0222','P0223','P0224','P0225','P0226','P0227','P0228','P0229','P0230','P0231'
        ];
        
        $count = 0;
        $total = count($codes);

        foreach ($codes as $i => $code) {
            if (FaultCode::where('code', $code)->where('make', $make)->exists()) {
                $this->line("({$i}/{$total}) Skip {$code}");
                continue;
            }
            
            $this->info("({$i}/{$total}) {$code}...");
            $data = $gemini->generateFaultCodeInfo($code, $make);
            
            if ($data) {
                FaultCode::create([
                    'code' => $code, 'code_type' => 'P', 'make' => $make,
                    'title_en' => $data['title'] ?? $code,
                    'title_ku' => $data['title_ku'] ?? null,
                    'description_en' => $data['description'] ?? null,
                    'description_ku' => $data['description_ku'] ?? null,
                    'symptoms_en' => $data['symptoms'] ?? null,
                    'symptoms_ku' => $data['symptoms_ku'] ?? null,
                    'possible_causes_en' => $data['possible_causes'] ?? null,
                    'possible_causes_ku' => $data['possible_causes_ku'] ?? null,
                    'how_to_fix_en' => $data['how_to_fix'] ?? null,
                    'how_to_fix_ku' => $data['how_to_fix_ku'] ?? null,
                    'severity' => $data['severity'] ?? 'medium',
                    'system' => $data['system'] ?? 'Engine',
                ]);
                $count++;
                $this->info("✓ SAVED");
            } else { 
                $this->warn("✗ FAIL"); 
            }
            sleep(10);
        }
        $this->info("Done! {$count}/{$total} codes.");
    }
}