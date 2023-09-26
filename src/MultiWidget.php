<?php

namespace Kenepa\MultiWidget;

use Exception;
use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Kenepa\MultiWidget\Concerns\HasTabs;

class MultiWidget extends Widget
{
    use HasTabs;

    protected static string $view = 'multi-widget::multi-widget';

    public int $currentWidget = 0;

    public ?Model $record = null;

    /**
     * Fully qualified class names of the widgets.
     */
    public array $widgets = [];

    public array $visibleWidgets;

    public function mount(): void
    {
        $this->visibleWidgets = $this->getVisibleWidgets();

        if (count($this->visibleWidgets) < 1) {
            return;
        }

        $tabSessionKey = $this->getMultiWidgetTabSessionKey();

        if (session()->has($tabSessionKey) && isset($this->visibleWidgets[$tabSessionKey]) && $this->shouldPersistMultiWidgetTabsInSession()) {
            $this->currentWidget = session()->get($tabSessionKey);
        }
    }

    /**
     * Selects a widget by its index.
     */
    public function selectWidget(int $index): void
    {
        $this->currentWidget = $index;

        if($this->shouldPersistMultiWidgetTabsInSession()) {
            session()->put(
                $this->getMultiWidgetTabSessionKey(),
                $this->currentWidget
            );
        }
    }

    /**
     * Returns the HTML of the currently selected widget.
     */
    public function getWidgetHTMLProperty(): ?string
    {
        if (! isset($this->visibleWidgets[$this->currentWidget])) {
            return null;
        }

        return Blade::render(
            "@livewire('" . $this->visibleWidgets[$this->currentWidget] . "', ['record' => \$record])",
            ['record' => $this->record]
        );
    }

    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    public function getVisibleWidgets(): array
    {
        return array_values($this->filterVisibleWidgets($this->widgets));
    }

    /**
     * Get the display name for a widget.
     *
     * @param string $widget The fully qualified class name of the widget.
     * @return string The display name of the widget.
     */
    public function getWidgetDisplayName($widget): string
    {
        $widget = new $widget;

        try {
            return $widget->getDisplayName();
        } catch (Exception $e) {
            return Str::of($widget::class)
                ->afterLast('\\')
                ->kebab()
                ->replace('-', ' ')
                ->title();
        }
    }

    /**
     * @param  array<class-string<Widget> | WidgetConfiguration>  $widgets
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    protected function filterVisibleWidgets(array $widgets): array
    {
        return array_filter($widgets, fn (string | WidgetConfiguration $widget): bool => $this->normalizeWidgetClass($widget)::canView());
    }

    /**
     * @param  class-string<Widget> | WidgetConfiguration  $widget
     * @return class-string<Widget>
     */
    protected function normalizeWidgetClass(string | WidgetConfiguration $widget): string
    {
        if ($widget instanceof WidgetConfiguration) {
            return $widget->widget;
        }

        return $widget;
    }
}
