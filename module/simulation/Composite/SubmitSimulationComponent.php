<?php

namespace DigicoSimulation\Composite;

class SubmitSimulationComponent extends AbstractSimulationComponent
{

    public function __construct()
    {
        parent::__construct();
    }

    public function isComposite(): bool
    {
        return false;
    }

    public function submit(): void
    {
        // TODO: Implement submit() method.
    }
}
