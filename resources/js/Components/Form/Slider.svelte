<script>
	import { Slider } from "bits-ui";

	let {
        class: className,
        value = $bindable(),
		min = 0,
		max = 100,
		step = 1,
		showTicks = false,
		multiple = false
    } = $props()

</script>

<Slider.Root
	class="slider"
	type={multiple ? "multiple" : "single"}
	bind:value
	{min} {max} {step}
>
	{#snippet children({ ticks, thumbs })}
		<span class="slider-track">
			<Slider.Range class="slider-range" />
		</span>

		{#each thumbs as thumb}
			<Slider.Thumb index={thumb} class="slider-thumb">
				{#if multiple}
					{value[thumb]}
				{:else}
					{value}
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

	:global(.slider) {
		@apply relative flex items-center h-11 w-full;
		@apply touch-none select-none;
	}

	.slider-track {
		@apply relative h-4 w-full grow cursor-pointer overflow-hidden;
		@apply border rounded-full;
		background-color: var(--bg-input);
		border-color: var(--border-soft);
	}

	:global(.slider-range) {
		@apply relative h-full border rounded-full;
		background: var(--gradient-primary);
		border-color: var(--border-primary);
	}

	:global(.slider-thumb) {
		@apply flex items-center justify-center h-8 w-8 z-10;
		@apply border rounded-full;
		@apply cursor-pointer shadow-sm active:scale-[0.98];
		@apply text-sm;
		@apply focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2;
		background: var(--bg-input);
		border-color: var(--border-soft);
		color: var(--text-input);
		&:hover {
			border-color: var(--border-input);
		}
	}

	.ticks {
		@apply absolute flex items-center justify-between px-3.5 h-full w-full;
	}

	:global(.slider-tick) {
		@apply h-1 w-1 bg-black/15 rounded-full;
	}

</style>