<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
class IdeaExport implements FromCollection, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use RegistersEventListeners;
    protected $ideas;

    public function __construct($ideas)
    {
        $this->ideas = $ideas;
    }

    public function collection()
    {
        return new Collection($this->ideas);
    }

    public static function afterSheet(AfterSheet $event)
    {

    }
}
