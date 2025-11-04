<script>
	import { getContext } from "svelte";
	import { Link } from '@inertiajs/svelte';
	import { route } from 'momentum-trail'

	import Box     from '@/Components/Core/Box.svelte'
	import Flex    from '@/Components/Core/Flex.svelte'
	import PanZoom from '@/Components/Core/PanZoom.svelte'
	import Icon    from '@/Components/UI/Icon.svelte'

	const {
		hoveredItem,
		hoverMapMarker,
		location,
		previewClass
	} = getContext("map-context");

	let {
		class: className
	} = $props()

	let cx = $state({
		preview: className || previewClass
	})
</script>



<PanZoom
	class="bg-background {cx.preview}"
	backgroundImage="/img/grid.png"
>
	<Box class="absolute map">
		<img class="h-full w-full" src={$location?.getMap?.()?.url} alt={location?.name} />
		{#each $location.mapItems?.all as item, i}
			{@render mapMarker(item, i)}
		{/each}
	</Box>
</PanZoom>

{#snippet mapMarker(item,i)}
	<Flex
		align="center" gap={1}
		class="backdrop-blur-sm cursor-pointer h-5 overflow-hidden p-1 rounded-full transition-all {$hoveredItem?.mappable?.id === item.mappable?.id ? "bg-white text-accent w-auto" : "bg-white/50 text-white w-5"}"
		onmouseover={() => hoverMapMarker(item)}
		onmouseout={() => hoverMapMarker()}
		style="position: absolute; left: {item.x}%; top: {item.y}%; transform: translate(-0.75rem,-50%);"
	>
		<Icon name={item.mappable?.icon || "MapPinSimple"} size="xs" weight="fill" />
		<Link
			href={route('locations.show', { location: item.mappable?.slug} )}
			class="font-style-tiny line-clamp-1 pr-1.5 text-accent truncate hover:underline"
		>{item.mappable?.name}</Link>
	</Flex>
{/snippet}