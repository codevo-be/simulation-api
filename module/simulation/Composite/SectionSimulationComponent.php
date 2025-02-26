<?php

namespace DigicoSimulation\Composite;

use Illuminate\Support\Collection;

class SectionSimulationComponent extends AbstractSimulationComponent
{
    private Collection $children;

    public function __construct()
    {
        parent::__construct();
        $this->children = new Collection();
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(AbstractSimulationComponent $child): void
    {
        $this->children->push($child);
    }

    public function removeChild(AbstractSimulationComponent $child): void
    {
        //TODO
    }

    public function isComposite(): bool
    {
        return true;
    }

    public function submit(): void
    {
        // TODO: Implement submit() method.
    }
}
