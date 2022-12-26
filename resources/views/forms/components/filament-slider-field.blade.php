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
    :color="$getColor()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
    :step="$getStep()"
    :min-value="$getMinValue()"
    :max-value="$getMaxValue()"
    :color="$getColor()"
    :ticks="$getTicks()"
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

            span = $refs.color_{{ str_replace('.', '_', $getId()) }}
            color = window.getComputedStyle( span , null).getPropertyValue( 'background-color' )
            track = window.getComputedStyle( this.range , null).getPropertyValue( 'background-color' )

            const rgbToArr = (s) => s.substr(0, 4) == 'rgba' ? s.substr(5, s.length - 6).trim().split(',') : s.substr(4, s.length - 5).trim().split(',')
            const rgbToHex = (r, g, b) => '#' + (1 << 24 | r << 16 | g << 8 | b).toString(16).slice(1)

            c = rgbToArr(color)
            t = rgbToArr(track)

            console.log('C: ' + c);
            console.log('T: ' + t);

            this.range.style.setProperty('--ui-slider-color', rgbToHex(c[0], c[1], c[2]))
            this.range.style.setProperty('--ui-slider-track', rgbToHex(t[0], t[1], t[2]))
            this.range.style.setProperty('--ui-slider-active', `${rgbToHex(c[0], c[1], c[2])}33`)

            this.setBubble(this.range, this.bubble)
        },

        setBubble(range, bubble) {
            val = range.value
            min = range.min ? range.min : 0
            max = range.max ? range.max : 100
            interval = 100 / (max - min)

            newVal = Number(((val - min) * 100) / (max - min))
            percent = val * interval

            bubble.innerHTML = val

            // Sorta magic numbers based on size of the native UI thumb
            bubble.style.left = `calc(${newVal}% + (${6 - newVal * 0.15}px))`

            range.style.setProperty('--ui-slider-percent', `${percent}%`)
        },
    }">
    <div id="filament-ui-slider-field" class="w-full h-14 flex gap-2" wire:ignore>
        <span class="flex-initial grid content-start -mt-1" x-ref="min_{{ str_replace('.', '_', $getId()) }}" x-text="minValue"></span>
        <div class="filament-ui-slider-field-wrapper grow">
            @php
                $outputColorClass = $getHexColor() ? "" : ("after:bg-{$getColor()}-600 bg-{$getColor()}-600" ?? "after:bg-gray-300 bg-gray-300");
                $outputColorStyle = $getHexColor() ? "background-color: " . ($getColor() ?? "#555") . ";" : "";
                $outputClass = "filament-ui-slider-field-value text-white {$outputColorClass}";
                $inputClass = "filament-ui-slider-field w-full bg-gray-100 border-gray-300 border";
                $colorClass = "{$outputColorClass}";
            @endphp
            <span x-ref="color_{{ str_replace('.', '_', $getId()) }}" class="{{ $colorClass }}" style="width: 0px; height: 0px; display: none; {{ $outputColorStyle }}"></span>
            <input
                wire:loading.attr="disabled"
                x-ref="input_{{ str_replace('.', '_', $getId()) }}"
                {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}"
                type="range"
                min="minValue"
                max="maxValue"
                step="{{ $getStep() }}"
                value="{{ $getState() }}"
                class="{{ $inputClass }}"
                list="steplist"
                />
            @if ($getTicks())
            <datalist class="filament-ui-slider-field-ticks w-full flex justify-between">
            @for ($i = 0; $i <= ($getMaxValue() - $getMinValue()); $i++)
                <option class="p-0 m-0 leading-none text-black">|</option>
            @endfor
            </datalist>
            @endif
            <output x-ref="value_{{ str_replace('.', '_', $getId()) }}" class="{{ $outputClass }}" style="{{ $outputColorStyle }}"></output>
        </div>
        <span class="grid content-start -mt-1" x-ref="max_{{ str_replace('.', '_', $getId()) }}" x-text="maxValue"></span>
    </div>
</x-dynamic-component>
