<script>
	import { getContext } from "svelte";

	import Box     from '@/Components/Core/Box.svelte'
	import Flex    from '@/Components/Core/Flex.svelte'
	import Inline  from '@/Components/Core/Inline.svelte'
	import PanZoom from '@/Components/Core/PanZoom.svelte'
	import Stack   from '@/Components/Core/Stack.svelte'
	import Button  from '@/Components/UI/Button.svelte'
	import Icon    from '@/Components/UI/Icon.svelte'

	const {
		getActive,
		getHovered,
		getItems,
		getLastClick,
		getMap,
		handleFileUpload,
		handleItemHover,
		handlePreviewClick,
		location,
		previewClass,
		pannable,
		zoomable
	} = getContext("map-context");

	let {
		class: className
	} = $props()

	let cx = $derived({
		active:  'bg-white text-neutral',
		cursor:  getActive() ? 'cursor-crosshair' : (pannable ? 'cursor-grab' : 'cursor-default'),
		preview: className || previewClass
	})
</script>



<PanZoom pannable={pannable} zoomable={zoomable}
	class="bg-background {cx.cursor} {cx.preview}"
	contentClass="flex items-center justify-center"
	backgroundImage="/img/grid.png"
	onclick={handlePreviewClick}
>
	{#if getMap?.()}


		<!-- Interaction Layer -->

		<Box class="absolute map">
			<img class="h-full w-full" src={getMap().url} alt={location?.name} />
			{#each getItems().all as item, i}
				{#if getActive()?.mappable?.id === item.mappable.id || (item.x && item.y)}
					{@render mapMarker(item, i)}
				{/if}
			{/each}
			{#if getActive()}
				<Stack gap={0} align="center" class="absolute backdrop-blur-sm bg-white/10 bottom-3 left-1/2 px-2 py-1 rounded -space-y-1 text-sm text-white w-32 translate-x-[-50%]">
					<span>{getActive().mappable.name}</span>
					<Inline gap={0.5}>
						<span class="font-light h-4 rounded text-center text-xs">{getLastClick()?.x?.toFixed(1) || '--'}%</span>,
						<span class="font-light h-4 rounded text-center text-xs">{getLastClick()?.y?.toFixed(1) || '--'}%</span>
					</Inline>
				</Stack>
			{/if}
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
		class="backdrop-blur-sm cursor-pointer h-5 overflow-hidden p-1 rounded-full transition-all {getHovered()?.mappable?.id === item.mappable?.id ? "bg-white text-accent w-auto" : "bg-white/50 text-white w-5"}"
		onmouseover={() => handleItemHover(item)}
		onmouseout={ () => handleItemHover()}
		style="position: absolute;
			left: {getActive()?.mappable.id === item.mappable.id ? getLastClick().x : item.x}%;
			top:  {getActive()?.mappable.id === item.mappable.id ? getLastClick().y : item.y}%;
			transform: translate(-0.75rem,-50%);"
	>
		<Icon name={item.mappable?.icon || "MapPinSimple"} size="xs" weight="fill" />
		<span class="font-style-tiny line-clamp-1 pr-1.5 text-accent truncate">{item.mappable?.name}</span>
	</Flex>
{/snippet}