<?php

namespace App\Exports;

use App\Models\Sondage;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SondageExport implements FromArray, WithHeadings, WithTitle
{
    protected Sondage $sondage;
    protected array $headings;
    protected array $rows;

    public function __construct(Sondage $sondage)
    {
        $this->sondage = $sondage->loadMissing(['enregistrements', 'champs']);
        $this->prepareData();
    }

    protected function prepareData(): void
    {
        $collections = $this->sondage->champs;
        $groupes = $this->sondage->enregistrements->groupBy('groupe_id');

        $headings = ['#'];
        foreach ($collections as $c) {
            $headings[] = $c->label;
        }
        $headings[] = 'Enregistré par';
        $this->headings = $headings;

        $rows = [];
        $counter = 1;
        foreach ($groupes as $groupeId => $champsDuGroupe) {
            $row = [$counter];
            foreach ($collections as $collection) {
                $champ = $champsDuGroupe->firstWhere('label', $collection->label);
                $row[] = $champ->value ?? '-';
            }
            $creatorName = optional($champsDuGroupe->first())->creator->name ?? 'Inconnu';
            $row[] = $creatorName;
            $rows[] = $row;
            $counter++;
        }
        $this->rows = $rows;
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function title(): string
    {
        return $this->sondage->titre ?: 'Export';
    }
}
