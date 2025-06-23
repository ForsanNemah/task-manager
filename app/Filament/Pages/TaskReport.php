<?php
namespace App\Filament\Pages;

use App\Models\Task;
use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Support\Collection;

class TaskReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.task-report';
    protected static ?string $navigationLabel = 'تقرير ساعات العمل';
    protected static ?string $title = 'تقرير ساعات العمل';

    public ?string $from = null;
    public ?string $to = null;
    public Collection $data;

    public function mount(): void
    {
        $this->loadReport();
    }

    public function submit(): void
    {
        $this->loadReport();
    }

    public function loadReport(): void
    {
        $query = Task::query()
            ->whereNotNull('task_time_after')
            ->where('task_time_after', '>', 0)
            ->whereNotNull('receiver_id');

        if (!empty($this->from)) {
            $query->whereDate('created_at', '>=', $this->from);
        }

        if (!empty($this->to)) {
            $query->whereDate('created_at', '<=', $this->to);
        }

        $this->data = $query
            ->selectRaw('receiver_id, COUNT(*) as task_count, SUM(task_time_after) as total_minutes')
            ->groupBy('receiver_id')
            ->with('receiver')
            ->get();
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\DatePicker::make('from')->label('من تاريخ'),
            Forms\Components\DatePicker::make('to')->label('إلى تاريخ'),
        ];
    }
}
