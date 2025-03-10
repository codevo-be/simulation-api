<?php

namespace DigicoSimulation\Jobs;

use DigicoSimulation\Services\Google\GoogleDriveService;
use DigicoSimulation\Services\SimulationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;

class CopyFileToGoogleDriveJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected string $simulationId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $simulationId)
    {
        $this->simulationId = $simulationId;
    }

    /**
     * Execute the job.
     */
    public function handle(GoogleDriveService $driveService, SimulationService $simulationService): void
    {
        // Appel à GoogleDriveService pour copier le fichier
        $spreadsheetId = $driveService->copyFile();

        // Mise à jour de la simulation avec l'ID du fichier
        $simulationService->linkSpreadsheetIdToSimulation($this->simulationId, $spreadsheetId);
    }
}
