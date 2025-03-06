<?php

namespace DigicoSimulation;

use Google\Client;
use Google\Exception;
use Google\Service\Sheets;
use Google\Service\Drive;

class GoogleClient extends Client
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->setApplicationName('Simulation'); //TODO à changer ?
        $this->setAuthConfig(storage_path('credentials.json'));
        $this->addScope(Sheets::DRIVE);
        $this->addScope(Sheets::DRIVE_FILE);
        $this->addScope(Sheets::SPREADSHEETS);
        $this->addScope(Drive::DRIVE);
    }
}
