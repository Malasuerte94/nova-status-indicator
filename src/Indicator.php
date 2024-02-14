<?php

namespace Malasuerte94\Fields;

use Closure;
use Laravel\Nova\Fields\Field;

class Indicator extends Field
{
    /**
     * Show element on creation
     *
     * @var bool
     */
    public $showOnCreation = false;

    /**
     * Show element on update.
     *
     * @var bool
     */
    public $showOnUpdate = false;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'indicator-field';

    /**
     * The callback to be used to hide the field.
     *
     * @var Closure
     */
    public $hideCallback;

    /**
     * Specify the labels that should be displayed.
     *
     * @param array $labels
     * @return $this
     */
    public function labels(array $labels): static
    {
        return $this->withMeta(['labels' => $labels, 'withoutLabels' => false]);
    }


    /**
     * Specify the icons of the field
     *
     * @param array $icons
     * @return $this
     */
    public function icons(array $icons): static
    {
        return $this->withMeta(['icons' => $icons]);
    }

    /**
     * Specify the colours that should be displayed.
     *
     * @param array $colors
     * @return $this
     */
    public function colors(array $colors): static
    {
        return $this->withMeta(['colors' => $colors]);
    }

    /**
     * The label to display when the value is not one of the defined statuses.
     *
     * @param string $label
     * @return $this
     */
    public function unknown(string $label): static
    {
        return $this->withMeta(['unknownLabel' => $label]);
    }

    /**
     * Display the raw value instead of a label.
     *
     * @return $this
     */
    public function withoutLabels(): static
    {
        return $this->withMeta(['withoutLabels' => true]);
    }

    /**
     * Define the callback or value(s) that should be used to hide the field.
     *
     * @param callable|array|mixed $hideCallback
     * @return $this
     */
    public function shouldHide($hideCallback): static
    {
        $this->hideCallback = $hideCallback;

        return $this;
    }

    /**
     * Define that the field should be hidden if falsy (0, false, null, '')
     *
     * @return $this
     */
    public function shouldHideIfNo(): static
    {
        $this->hideCallback = function ($value) {
            return !$value;
        };

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function resolveForDisplay($resource, $attribute = null): void
    {
        parent::resolveForDisplay($resource, $attribute);

        if (is_null($this->hideCallback)) {
            return;
        }

        if (is_callable($this->hideCallback)) {
            $shouldHide = call_user_func($this->hideCallback, $this->value, $resource);
        } elseif (is_array($this->hideCallback)) {
            $shouldHide = in_array($this->value, $this->hideCallback, false);
        } else {
            $shouldHide = $this->value == $this->hideCallback;
        }

        $this->withMeta(['shouldHide' => (bool)$shouldHide]);
    }
}
