<?php

namespace App\Service;

use App\Entity\Program;

class ProgramDuration
{
    public function calculate(Program $program): string
    {
        $duration = 1;
        foreach ($program->getSeasons() as $season) {
            foreach ($season->getEpisodes() as $episode) {
                $duration += $episode->getDuration();
            }
        }
        return strval($duration);
    }
}
