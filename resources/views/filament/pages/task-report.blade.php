<x-filament::page>
    <div class="space-y-6">

        {{-- ✅ نموذج الفلترة --}}
        <x-filament::card>
            <form wire:submit.prevent="submit">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    {{ $this->form }}

                    {{-- ✅ زر التطبيق --}}
                    <div>
                        <x-filament::button type="submit" color="primary">
                            تطبيق الفلتر
                        </x-filament::button>
                    </div>
                </div>
            </form>
        </x-filament::card>

        {{-- ✅ جدول التقرير --}}
        <x-filament::card>
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-start">
                    <tr>
                        <th class="px-4 py-2">الموظف</th>
                        <th class="px-4 py-2">عدد المهام</th>
                        <th class="px-4 py-2">الدقائق</th>
                        <th class="px-4 py-2">الساعات (مقرب)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $row)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $row->receiver?->name ?? 'غير معروف' }}</td>
                            <td class="px-4 py-2">{{ $row->task_count }}</td>
                            <td class="px-4 py-2">{{ $row->total_minutes }}</td>
                            <td class="px-4 py-2">{{ round($row->total_minutes / 60, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">
                                لا توجد بيانات ضمن الفترة المحددة.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-filament::card>

    </div>
</x-filament::page>
