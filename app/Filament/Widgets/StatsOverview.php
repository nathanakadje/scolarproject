<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassModel;
use App\Models\Subject;
class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make('Étudiants actifs', Student::where('status', 'active')->count())
                ->description('Total des étudiants actifs')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Enseignants', Teacher::where('status', 'active')->count())
                ->description('Total des enseignants actifs')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),

            Stat::make('Classes', ClassModel::where('is_active', true)->count())
                ->description('Classes disponibles')
                ->descriptionIcon('heroicon-m-building-library')
                ->color('warning'),

            Stat::make('Matières', Subject::where('is_active', true)->count())
                ->description('Matières enseignées')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('primary'),
        ];
    }
}
