<script>

	import clsx from 'clsx'
	import { getContext } from "svelte";
	import Box     from '@/Components/Core/Box.svelte'
	import Flex    from '@/Components/Core/Flex.svelte'
	import Inline  from '@/Components/Core/Inline.svelte'
	import PanZoom from '@/Components/Core/PanZoom.svelte'
	import Button  from '@/Components/UI/Button.svelte'
	import Heading from '@/Components/UI/Heading.svelte'
	import Icon    from '@/Components/UI/Icon.svelte'

	const {
		getActive,
		getHovered,
		getItems,
		getLastClick,
		getLocation,
		getMap,
		handleFileUpload,
		handleItemHover,
		handlePreviewClick,
		previewClass,
		pannable,
		zoomable
	} = getContext("map-context");

	let {
		class: className,
		onBackClick,
		onItemClick
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		active:  'bg-white text-neutral',
		cursor:  getActive() ? 'cursor-crosshair' : (pannable ? 'cursor-grab'
		 : 'cursor-default'),
		preview: className || previewClass,
		marker: clsx('backdrop-blur-sm cursor-pointer h-5 overflow-hidden p-1 rounded-full transition-all'),
		markerActive: clsx('bg-white text-accent w-auto'),
		markerInactive: clsx('bg-white/50 text-white w-5')
	})


	/**
	 * Check if the given item is active
	 * @param item | the item to check
	 * @return {boolean}
	 */
	function isActive(item) {
		return getActive()?.mappable?.id === item.mappable?.id
	}

	/**
	 * Check if the given item is hovered in either the legend or the map
	 * @param item | the item to check
	 * @return {boolean}
	 */
	function isHovered(item) {
		return getHovered()?.mappable?.id === item.mappable?.id
	}

</script>



<PanZoom pannable={pannable} zoomable={zoomable}
	class="bg-background {cx.cursor} {cx.preview}"
	contentClass="flex items-center justify-center"
	backgroundImage="/img/grid.png"
	onclick={handlePreviewClick}
>
	<Inline class="absolute backdrop-blur-sm bg-white/20 top-1 left-1 min-h-8 rounded text-white z-10">
		{#if getLocation().mapData}
			<Button size="xs" class="h-8 w-8 rounded-l hover:bg-white/20"
				icon="ArrowLeft"
				onclick={() => {
					onBackClick(getLocation().mapData)
				}}
			/>
		{/if}
		<Heading is="h4" as="h6" class="px-2">{getLocation().name}</Heading>
	</Inline>

	{#if getMap?.()}


		<!-- Interaction Layer -->

		<Box class="absolute map">
			<img class="h-full w-full" src={getMap().url} alt={location?.name} />
			{#each getItems().all as item, i}
				{#if isActive(item) || (item.x && item.y)}
					{@render mapMarker(item, i)}
				{/if}
			{/each}
			
			<!-- {#if getActive()}
				<Stack gap={0} align="center" class="absolute backdrop-blur-sm bg-white/10 bottom-3 left-1/2 px-2 py-1 rounded -space-y-1 text-sm text-white w-32 translate-x-[-50%]">
					<span>{getActive().mappable.name}</span>
					<Inline gap={0.5}>
						<span class="font-light h-4 rounded text-center text-xs">{getLastClick()?.x?.toFixed(1) || '--'}%</span>,
						<span class="font-light h-4 rounded text-center text-xs">{getLastClick()?.y?.toFixed(1) || '--'}%</span>
					</Inline>
				</Stack>
			{/if} -->
		</Box>
	{:else}


		<!-- Upload Button -->

		<Button style="soft" theme="accent"
			label="Upload" onclick={handleFileUpload}
		/>
	{/if}
</PanZoom>



{#snippet mapMarker(item,i)}
	<Flex
		align="center" gap={1}
		class="{cx.marker} {isHovered(item) ? cx.markerActive : cx.markerInactive}"
		onmouseover={() => handleItemHover(item)}
		onmouseout={ () => handleItemHover()}
		onclick={ () => onItemClick(item) }
		style="position: absolute;
			left: {isActive(item) ? getLastClick().x : item.x}%;
			top:  {isActive(item) ? getLastClick().y : item.y}%;
			transform: translate(-0.75rem,-50%);"
	>
		<Icon name={item.mappable?.icon || "MapPinSimple"} size="xs" weight="fill" />
		<span class="font-style-tiny line-clamp-1 pr-1.5 text-accent truncate">{item.mappable?.name}</span>
	</Flex>
{/snippet}