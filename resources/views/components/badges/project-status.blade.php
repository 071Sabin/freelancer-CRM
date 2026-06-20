@props(['project_status'])

@php
    $status = $project_status instanceof \App\Enums\ProjectStatus 
        ? $project_status 
        : \App\Enums\ProjectStatus::tryFrom($project_status ?? '');
@endphp


@if ($status)
    <span
        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md ring-1 ring-inset {{ $status->colourClass() }}">
        {{ $status->label() }}
    </span>
@else
    <span class="text-xs text-neutral-500">
        Unknown
    </span>
@endif
