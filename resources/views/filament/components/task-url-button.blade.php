@props(['state'])

@if (filled($state))
    <a href="{{ $state }}" target="_blank"
       class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
        🔗 فتح الرابط
    </a>
@else
    <span class="text-gray-400 text-sm">لا يوجد رابط</span>
@endif
