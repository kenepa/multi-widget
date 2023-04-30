<div class="filament-widget col-span-full">
    <div>
        <div class="block">
            <nav class="flex space-x-4" aria-label="Tabs">
                @foreach ($widgets as $index => $widget)
                    <span wire:click="selectWidget({{ $index }})" class="cursor-pointer {{ $currentWidget == $index ? 'text-gray-700' : 'text-gray-400' }} hover:text-gray-700 rounded-md px-3 py-2 text-sm font-medium">
                        {{ $this->getWidgetDisplayName($widget) }}
                    </span>
                @endforeach
            </nav>
        </div>
    </div>

    {!! $this->widgetHTML !!}
</div>
