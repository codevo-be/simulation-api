<?php

namespace DigicoSimulation\Composite;

abstract class AbstractSimulationComponent
{
    protected string $sectionName;
    protected array $questions;
    protected ?AbstractSimulationComponent $parent;

    public function __construct()
    {
    }

    public function getSectionName(): string
    {
        return $this->sectionName;
    }

    public function getParent(): ?AbstractSimulationComponent
    {
        return $this->parent;
    }

    public function addQuestion(string $question): void
    {
        //TODO
    }

    public function removeQuestion(string $question): void
    {
        //TODO
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public abstract function isComposite(): bool;

    public abstract function submit(): void;
}
