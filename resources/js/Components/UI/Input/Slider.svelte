<script>
	import { Slider } from "bits-ui";
	import { Flex, Stack } from '@/Components/Core'
	import Icon from '@/Components/UI/Icon.svelte'
	import Label from '@/Components/UI/Label.svelte'
	import clsx from 'clsx'

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

	// Compute the actual min/max values based on reverse
    // const actualMin = $derived(reverse ? Math.max(min, max) : Math.min(min, max))
    // const actualMax = $derived(reverse ? Math.min(min, max) : Math.max(min, max))

	// function displayValue(thumbIndex) {
    //     if (!showValue) return ''
    //     const val = multiple ? value[thumbIndex] : value
    //     return reverse ? actualMax - val + actualMin : val
    // }

	let cx = $derived({
		slider: clsx('slider relative inline-flex items-center min-w-32 touch-none select-none', `py-${size}`, {
			'style-disabled': restProps.disabled
		}, className),
		track: clsx('slider-track relative h-3 w-full grow overflow-hidden my-1 rounded-full', {
			'bg-accent shadow-accent-strong': 	style === 'empty' || style === 'both',
			'bg-white shadow-neutral-softest': 	style === 'fill'  || style === 'none'
		}),
		range: clsx('slider-range relative h-full rounded-full', {
			'bg-accent shadow-accent-strong': 	style === 'fill'  || style === 'both',
			'bg-white shadow-neutral-softest': 	style === 'empty' || style === 'none'
		}),
		thumb: clsx('border cursor-pointer flex items-center justify-center min-h-5 min-w-5 rounded-full shadow-sm text-sm z-10',
			'focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2',
			'bg-white border-neutral-soft text-white',
			'hover:min-h-6 hover:min-w-6 hover:border-accent'
		),
		ticks: clsx('absolute flex items-center justify-between px-2 h-full w-full'),
		tick: clsx('h-1 w-1 bg-black/15 rounded-full'),
	})

</script>



<Slider.Root
	class={cx.slider}
	type={multiple ? "multiple" : "single"}
	bind:value
	{min} {max} {step}
	{...restProps}
>
	{#snippet children({ ticks, thumbs })}
		<span class={cx.track}>
			<Slider.Range class={cx.range} />
		</span>

		{#each thumbs as thumb}
			<Slider.Thumb index={thumb} class={cx.thumb}>
				{#if showValue}
					{multiple ? value[thumb] : value}
				{/if}
			</Slider.Thumb>
		{/each}

		{#if showTicks}
			<div class={cx.ticks}>
				{#each ticks as tick}
					<Slider.Tick class={cx.tick} />
				{/each}
			</div>
		{/if}

	{/snippet}
</Slider.Root>