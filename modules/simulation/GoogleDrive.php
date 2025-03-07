<?php

namespace DigicoSimulation;

use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\Permission;

class GoogleDrive
{
    private GoogleClient $client;
    public function __construct()
    {
        $this->client = new GoogleClient();
    }

    public function createFolder()
    {
        try {
            $driverService = new Drive($this->client);

            // 1. Créer le dossier
            $fileMetaData = new DriveFile([
                'name' => 'Invoices',
                'mimeType' => 'application/vnd.google-apps.folder'
            ]);

            $file = $driverService->files->create($fileMetaData, [
                'fields' => 'id'
            ]);

            $folderId = $file->id;
            printf("Folder ID: %s\n", $folderId);

            // 2. Ajouter des permissions pour chaque email
            $permission = new \Google\Service\Drive\Permission();
            $permission->setType('user');      // Type d'utilisateur (user, group, domain)
            $permission->setRole('writer');    // Rôle (reader, writer, owner)
            $permission->setEmailAddress('alexis.vandenbroeck@gmail.com'); // Email à qui donner les droits

            $driverService->permissions->create($folderId, $permission, [
                'sendNotificationEmail' => false, // Ne pas envoyer d'email de notification
                'supportsAllDrives' => true // Obligatoire si tu travailles avec un Shared Drive
            ]);
            print("");
            printf("Permission accordée à : %s\n", 'alexis.vandenbroeck@gmail.com');

            return $folderId;
        } catch (\Exception $e) {
            dd("Erreur : " . $e->getMessage());
        }
    }


    public function getFolders()
    {
        try
        {
            $driverService = new Drive($this->client);
            $files = array();
            $pageToken = null;

            do {
                $response = $driverService->files->listFiles(array(
                    'q' => "mimeType='application/vnd.google-apps.folder'",
                    'spaces' => 'drive',
                    'pageToken' => $pageToken,
                    'fields' => 'nextPageToken, files(id, name)',
                ));
                foreach ($response->getFiles() as $file) {
                    printf("Found file: %s (%s)\n", $file->name, $file->id);
                }
                array_push($files, $response->getFiles());

                $pageToken = $response->pageToken;
            } while ($pageToken !== null);
            return $files;
        } catch (\Exception $e)
        {
            dd("Error message: " . $e->getMessage());
        }
    }
}
