<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
    :step="$getStep()"
    :min-value="$getMinValue()"
    :max-value="$getMaxValue()"
    x-data="{
        state: $wire.entangle('{{ $getStatePath() }}').defer,
        minValue: {{ $getMinValue() }},
        maxValue: {{ $getMaxValue() }},
        min: $refs.min_{{ str_replace('.', '_', $getId()) }},
        max: $refs.max_{{ str_replace('.', '_', $getId()) }},
        range: $refs.input_{{ str_replace('.', '_', $getId()) }},
        bubble: $refs.value_{{ str_replace('.', '_', $getId()) }},

        init() {
            this.min.innerHTML = this.minValue
            this.max.innerHTML = this.maxValue
            this.range.min = this.minValue
            this.range.max = this.maxValue
            this.range.addEventListener('input', () => {
                this.setBubble(this.range, this.bubble)
            })

            this.setBubble(this.range, this.bubble)
        },

        setBubble(range, bubble) {
            val = range.value
            min = range.min ? range.min : 0
            max = range.max ? range.max : 100
            newVal = Number(((val - min) * 100) / (max - min))
            bubble.innerHTML = val

            // Sorta magic numbers based on size of the native UI thumb
            bubble.style.left = `calc(${newVal}% + (${6 - newVal * 0.15}px))`
        }
    }">
    <div class="w-full h-14 flex gap-2" wire:ignore>
        <span class="flex-initial grid content-start -mt-1" x-ref="min_{{ str_replace('.', '_', $getId()) }}" x-text="minValue"></span>
        <div class="filament-ui-slider-field-wrapper grow">
            <input
                wire:loading.attr="disabled"
                x-ref="input_{{ str_replace('.', '_', $getId()) }}"
                {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}"
                type="range"
                min="minValue"
                max="maxValue"
                step="{{ $getStep() }}"
                value="{{ $getState() }}"
                class="filament-ui-slider-field w-full" />
            <output x-ref="value_{{ str_replace('.', '_', $getId()) }}" class="filament-ui-slider-field-value after:bg-primary-600 bg-primary-600 text-white"></output>
        </div>
        <span class="grid content-start -mt-1" x-ref="max_{{ str_replace('.', '_', $getId()) }}" x-text="maxValue"></span>
    </div>
</x-dynamic-component>
