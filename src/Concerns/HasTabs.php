<?php

namespace Kenepa\MultiWidget\Concerns;

trait HasTabs {
    public function getMultiWidgetTabSessionKey(): string
    {
        $widget = class_basename($this::class);

        return "multi_widget.{$widget}_active_tab";
    }

    public function shouldPersistMultiWidgetTabsInSession(): bool
    {
        return false;
    }
}