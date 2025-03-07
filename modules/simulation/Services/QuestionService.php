<?php

namespace DigicoSimulation\Services;

use DigicoSimulation\Models\Question;

class QuestionService
{
    public function findQuestionFromLabel($label)
    {
        return Question::where('label', $label)->first();
    }
}
