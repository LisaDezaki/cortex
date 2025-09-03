<script>
	import { Slider } from "bits-ui";

	let {
        class: className,
        value = $bindable(),
		min = 0,
		max = 100,
		step = 1,
		style = "fill",
		showValue = false,
		showTicks = false,
		multiple = false,
		reverse = false,
		...restProps
    } = $props()

	// Compute the actual min/max values based on reverse
    // const actualMin = $derived(reverse ? Math.max(min, max) : Math.min(min, max))
    // const actualMax = $derived(reverse ? Math.min(min, max) : Math.max(min, max))

	// function displayValue(thumbIndex) {
    //     if (!showValue) return ''
    //     const val = multiple ? value[thumbIndex] : value
    //     return reverse ? actualMax - val + actualMin : val
    // }

</script>





<Slider.Root
	class="{className} input-slider {restProps.disabled ? "style-disabled" : ""}"
	type={multiple ? "multiple" : "single"}
	bind:value
	{min} {max} {step}
	{...restProps}
>
	{#snippet children({ ticks, thumbs })}
		<span class="input-slider-track {["empty","both"].includes(style) ? "accent" : "neutral"}">
			<Slider.Range class="slider-range {["fill","both"].includes(style) ? "accent" : "neutral"}" />
		</span>

		{#each thumbs as thumb}
			<Slider.Thumb index={thumb} class="slider-thumb">
				{#if showValue}
					{multiple ? value[thumb] : value}
				{/if}
			</Slider.Thumb>
		{/each}

		{#if showTicks}
			<div class="ticks">
				{#each ticks as tick}
					<Slider.Tick class="slider-tick" />
				{/each}
			</div>
		{/if}

	{/snippet}
</Slider.Root>

<style lang="postcss">

	:global(.input-slider) {
		@apply relative inline-flex items-center h-10 w-full;
		@apply touch-none select-none;
	}

	.input-slider-track {
		@apply relative h-4 w-full grow overflow-hidden;
		@apply border-none rounded-full;
		border: none;
		box-shadow: 0 1px 0 var(--shadow-lowlight);
		&.accent {
			background: var(--bg-accent-gradient);
		}
		&.neutral {
			background-color: var(--bg-input);
		}
	}

	:global(.slider-range) {
		@apply relative h-full rounded-full;
		/* background: var(--bg-accent-gradient); */
		&.accent {
			background: var(--bg-accent-gradient);
		}
		&.neutral {
			background-color: var(--bg-input);
		}
	}

	:global(.slider-thumb) {
		@apply flex items-center justify-center min-h-5 min-w-5 z-10;
		@apply border rounded-full;
		@apply cursor-pointer shadow-sm;
		@apply text-sm;
		@apply focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2;
		background: var(--bg-accent-gradient);
		border-color: var(--border-accent-strong);
		color: var(--text-white);
		&:hover {
			@apply min-h-6 min-w-6;
		}
	}

	.ticks {
		@apply absolute flex items-center justify-between px-2 h-full w-full;
	}

	:global(.slider-tick) {
		@apply h-1 w-1 bg-black/15 rounded-full;
	}

</style>