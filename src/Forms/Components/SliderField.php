<?php

namespace DiegoBas\SliderField\Forms\Components;

use Carbon\Traits\Converter;
use Closure;
use Filament\Forms\Components\Concerns;
use Filament\Forms\Components\Field;

class SliderField extends Field
{
    use Concerns\HasLabel;
    use Concerns\HasState;
    use Concerns\HasStep;

    protected string $view = 'filament-slider-field::forms.components.filament-slider-field';

    protected int | Closure $minValue = 0;
    protected int | Closure $maxValue = 100;
    protected string | Closure | null $color = 'primary';

    protected function setUp(): void
    {
        parent::setUp();

        $this->default($this->minValue);

        $this->dehydrateStateUsing(static function (SliderField $component, $state) {
            if (blank($state)) {
                return $component->default;
            }

            return (int)$state;
        });
    }

    public function color(string | Closure | null $color = 'primary'): static
    {
        $this->color = $color;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->evaluate($this->color);
    }

    public function minValue(int|Closure $minValue = 0): static
    {
        $this->minValue = $minValue;

        return $this;
    }

    public function getMinValue(): int
    {
        return $this->evaluate($this->minValue);
    }

    public function maxValue(int|Closure $maxValue = 100): static
    {
        $this->maxValue = $maxValue;

        return $this;
    }

    public function getMaxValue(): int
    {
        return $this->evaluate($this->maxValue);
    }
}
