<script>
	import { Slider } from "bits-ui";
	import { Flex, Stack } from '@/Components/Core'
	import Icon from '@/Components/UI/Icon.svelte'
	import Label from '@/Components/UI/Inputs/Label.svelte'

	let {
        class: className,
		icon,
		iconSize,
		label,
		labelIcon,
		min = 0,
		max = 100,
		size = "md",
		step = 1,
		style = "fill",
		showValue = false,
		showTicks = false,
		multiple = false,
		reverse = false,
        value = $bindable(),
		...restProps
    } = $props()

	const marginSizes = {
		xs: "my-0",
		sm: "my-0.25",
		md: "my-0.5",
		lg: "my-1",
		xl: "my-1.5"
	}

	// Compute the actual min/max values based on reverse
    // const actualMin = $derived(reverse ? Math.max(min, max) : Math.min(min, max))
    // const actualMax = $derived(reverse ? Math.min(min, max) : Math.max(min, max))

	// function displayValue(thumbIndex) {
    //     if (!showValue) return ''
    //     const val = multiple ? value[thumbIndex] : value
    //     return reverse ? actualMax - val + actualMin : val
    // }

</script>



<Stack align="between" gap={0.5} class="w-full {className}">
	
	{#if label}
		<Flex align="center" justify="start" gap={1} class="font-light pt-0.5 pl-1 text-neutral-soft w-full">
			{#if labelIcon}
				<Icon name={labelIcon} size="xs" />
			{/if}
			<Label
				class="font-style-label"
				value={label}
			/>
		</Flex>
	{/if}
	
	<Slider.Root
		class="input-slider {marginSizes[size]} {restProps.disabled ? "style-disabled" : ""}"
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
</Stack>


<style lang="postcss">

	:global(.input-slider) {
		@apply relative inline-flex items-center w-full;
		@apply touch-none select-none;
	}

	.input-slider-track {
		@apply relative h-4 w-full grow overflow-hidden my-1;
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
		&.accent {
			background: var(--bg-accent-gradient);
		}
		&.neutral {
			background-color: var(--bg-input);
		}
	}

	:global(.slider-thumb) {
		@apply flex items-center justify-center min-h-6 min-w-6 z-10;
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