<script>
	import { getContext } from "svelte";

	import Inline from '@/Components/Core/Inline.svelte'
	import Icon from '@/Components/UI/Icon.svelte'

	const {
		hoveredItem,
		hoverMapMarker,
		location,
	} = getContext("map-context");
</script>



<ul class="grid grid-cols-2 gap-[1px] min-w-48 shrink-0 w-full">
	{#each $location?.mapItems?.all as item}
		<li class="col-span-1">
			<Inline gap={1.5} class="cursor-pointer text-sm {$hoveredItem?.mappable?.id === item.mappable?.id ? 'text-accent bg-accent-softest' : 'text-neutral'}"
				onmouseover={() => hoverMapMarker(item)}
				onmouseout={() => hoverMapMarker()}
			>
				<Icon name={item.mappable.icon || 'MapPinSimple'} size="sm" class="p-1 {$hoveredItem?.mappable?.id === item.mappable?.id ? 'bg-accent text-white' : 'bg-neutral-softest text-neutral'}" />
				<span class="line-clamp-1">{item.mappable.name}</span>
			</Inline>
		</li>
	{/each}
</ul>