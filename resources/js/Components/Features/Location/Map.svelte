<script>
	import { Link } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	import { Box, Flex, Inline, PanZoom, Preview, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Icon from '@/Components/UI/Icon.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'
	
	let {
		activeChild,
		class: className,
		constrain = false,
		coordinates = $bindable([null,null]),
		debug,
		markerClass,
		legend,
		location = $bindable(null),
		minZoom  = $bindable(0.5),
		maxZoom  = $bindable(3),
		pannable = true,
		position = $bindable({ x:0, y:0 }),
		setCoordinates,
		zoomable = true,
		zoom     = $bindable(1),
        ...restProps
    } = $props()

	let history    = $state([])

	// function hasMapAndChildren(location) {
	// 	return ( location.children?.length > 0 || location.descendants?.length > 0 ) && location.map
	// }

	function mapClick(e) {
		coordinates = [
			e.offsetX/e.originalTarget.width*100,
			e.offsetY/e.originalTarget.height*100
		]
		console.log(coordinates)
	}

	function setLocation(loc) {
		history = [ ...history, location ]
		location = loc
	}

	// function undo(id) {
	// 	let index = history.findIndex(h => h.id === id)
	// 	setLocation(history[index])
	// 	history.length = index
	// }

</script>



<style lang="postcss">

	:global(.map-container) {
		@apply h-full overflow-hidden w-full;

		:global(.map) {
			/* @apply relative object-cover min-h-full min-w-full overflow-hidden; */
		}
	}
	
</style>



<Flex align="center" justify="center" gap={0} class="bg-background overflow-hidden rounded w-full {className}">

	{#if location.getMap?.() === null}
		<Button style="soft" theme="accent" label="Upload map" onclick={() => location?.openModal('setMap')} />
	{:else}
	
		<PanZoom
			bind:position {pannable}
			bind:zoom {zoomable}
			constrain={constrain}
			class="bg-neutral-soft aspect-square flex-grow"
			backgroundImage="/img/grid.png"
			{minZoom} {maxZoom}
			{debug}
		{...restProps}>


			<!-- Controls -->
		
			{#snippet controls()}
				{#if zoomable}
					<Flex gap={0} class="absolute top-1.5 right-1.5 z-10">
						<Button class="w-9 rounded-l-full" style="glass" icon="MagnifyingGlassMinus" iconSize="sm" onclick={() => {zoom /= 1.2}} disabled={zoom <= minZoom} />
						<Button class="w-9 rounded-r-full" style="glass" icon="MagnifyingGlassPlus"  iconSize="sm" onclick={() => {zoom *= 1.2}} disabled={zoom >= maxZoom} />
					</Flex>
				{/if}
			{/snippet}
		
		
			<!-- Map Image -->
			
			<Box class="absolute map" onclick={mapClick}>
				<img class="h-full w-full" src={location.getMap?.()?.url} alt={location?.name} />
		
				{#if location?.mapItems?.all}
					{#each location?.mapItems?.all as item,i}
						{@render mapMarker(item,i)}
					{/each}
				<!-- {:else if location?.descendants?.items}
					{#each location?.descendants?.items as location,i}
						{@render mapMarker(location,i)}
					{/each} -->
				{/if}

				{#if setCoordinates && coordinates[0] && coordinates[1]}
					<Flex align="center" justify="center"
						class="absolute pointer-events-none text-danger translate-x-[-50%] translate-y-[-50%] h-7 w-7 z-10"
						style="left: {coordinates[0]}%; top: {coordinates[1]}%;"
					>
						<Icon name="MapPinSimple" size="xl" weight="fill" class="translate-y-[-50%]" />
						<Box class="absolute inset-0 border border-danger rounded-full" />
					</Flex>
				{/if}
			</Box>
		
		</PanZoom>
		
		
		<!-- Points of Interest -->

		{#if legend}
			<Stack class="h-full p-1 pr-1.5 rounded-r shrink-0 w-48 backdrop-blur-md overflow-y-auto">
				{#each legend as item}
					<Inline class="cursor-pointer p-1.5 rounded w-full hover:bg-neutral-softest">
						<Icon name={item.icon} size="sm" weight="bold" />
						<span class="font-style-small font-medium line-clamp-1">{item.label}</span>
						<Icon name="CaretDown" size="xs" weight="fill" class="text-neutral-softer ml-auto" />
					</Inline>
					{#if item.items?.length > 0}
						<Stack class="py-1">
							{#each item.items as subitem}
								<Inline gap={2} class="cursor-pointer px-1.5 py-1 rounded w-full hover:bg-neutral-softest">
									{#if subitem.image}
										<Thumbnail class="h-6 w-6" src={subitem.image?.url} />
									{:else}
										<Icon class="text-accent" name={subitem.icon} size="sm" />
									{/if}
									<span class="font-style-small line-clamp-1">{subitem.label}</span>
								</Inline>
							{/each}
						</Stack>
					{/if}
				{/each}
			</Stack>
		{/if}
	{/if}
</Flex>


{#snippet mapMarker(item,i)}
	<Flex
		align="center" gap={1}
		class="backdrop-blur-sm cursor-pointer h-5 overflow-hidden p-1 rounded-full transition-all {activeChild?.slug === item.mappable?.slug ? "bg-white text-accent w-auto" : "bg-white/50 text-white w-5"}"
		style="position: absolute; left: {item.x}%; top: {item.y}%; transform: translate(-0.75rem,-50%);"
		onhover={() => activeChild = item}
	>
		<Icon name={item.mappable?.icon || "MapPinSimple"} size="xs" weight="fill" />
		<Link
			href={route('locations.show', { location: item.mappable?.slug} )}
			class="font-style-tiny line-clamp-1 pr-1.5 text-accent truncate hover:underline"
		>{item.mappable?.name}</Link>
	</Flex>
{/snippet}