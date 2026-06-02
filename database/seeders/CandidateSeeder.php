<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidates = [
            ['name' => 'MUTABAZI', 'position' => 'District Mayor', 'details' => 'Experienced public servant running for community progress.', 'photo_url' => 'images/candidates/mutabazi.svg'],
            ['name' => 'Habimana', 'position' => 'District Mayor', 'details' => 'Committed to transparency and citizen participation.', 'photo_url' => 'images/candidates/default.svg'],
            ['name' => 'Alice Uwase', 'position' => 'District Mayor', 'details' => 'Focused on education and local development.'],
            ['name' => 'Benjamin Nkurunziza', 'position' => 'District Mayor', 'details' => 'Leader with a strong record in infrastructure projects.'],
            ['name' => 'Clarisse Mukamana', 'position' => 'Councilor', 'details' => 'Champion for youth and community services.'],
            ['name' => 'David Mugisha', 'position' => 'Councilor', 'details' => 'Advocate for sustainable local business growth.'],
        ];

        foreach ($candidates as $candidate) {
            Candidate::updateOrCreate(
                ['name' => $candidate['name'], 'position' => $candidate['position']],
                [
                    'details' => $candidate['details'],
                    'photo_url' => $candidate['photo_url'] ?? 'images/candidates/default.svg',
                ]
            );
        }
    }
}
