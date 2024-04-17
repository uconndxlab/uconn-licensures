<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Licensure;
use Carbon\Carbon;

class ScrapeExistingLicensures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uconn:scrape-existing-licensures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull licensure data from the UConn state licensure website.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $territories = Http::get('https://statelicensure.uconn.edu/admin/category/getTerrorities')->json();

        $licensures = [];

        foreach($territories as $key => $territory) {
            $this->info("Scraping territory: {$territory}");

            $response = Http::get("https://statelicensure.uconn.edu/admin/program/getDetails/$territory");

            $licensures = array_merge($licensures, $response->json());
        }

        // Save the data to a file
        Storage::put('public/licensures.json', json_encode($licensures));

        // Save the data to the database
        foreach($licensures as $licensure) {
            Licensure::updateOrCreate([
                'id' => $licensure['ID'],
            ], [
                'program_id' => $licensure['PROGRAM_ID'],
                'school_college' => $licensure['SCHOOL_COLLEGE'],
                'program_name' => $licensure['PROGRAM_NAME'],
                'weblink' => $licensure['WEBLINK'],
                'state_name' => $licensure['STATE_NAME'],
                'state_abbreviation' => $licensure['STATE_ABBREVIATION'],
                'status' => $licensure['STATUS'],
                'description' => $licensure['DESCRIPTION'],
                'created_at' => Carbon::parse($licensure['LAST_UPDATE'])
            ]);
        }
    }
}
