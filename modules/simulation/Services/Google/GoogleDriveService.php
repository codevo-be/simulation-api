<?php

namespace DigicoSimulation\Services\Google;

use DigicoSimulation\GoogleClient;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class GoogleDriveService
{
    private GoogleClient $client;
    public mixed $dataConfig;
    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->dataConfig = json_decode(file_get_contents(base_path("modules/simulation/sheet_config.json")), true);
    }

    public function createFolder()
    {

    }

    public function copyFile(): string
    {
        $templateId = $this->dataConfig['template_id'];
        $destinationFolderId = $this->dataConfig['unknown_folder_id'];
        try
        {
            $drive = new Drive($this->client);
            $fileMetadata = new Drivefile([
                'parents' => [$destinationFolderId],
            ]);

            $copiedFile = $drive->files->copy($templateId, $fileMetadata, [
                'fields' => 'id'
            ]);

            return $copiedFile->id;
        }
        catch (\Exception $e)
        {
            dd("Erreur : " . $e->getMessage());
        }
    }
}
