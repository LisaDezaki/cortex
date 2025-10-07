<script>
	import { Link } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	import { Box, Flex, Inline, PanZoom, Preview, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Icon from '@/Components/UI/Icon.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'
	
	let {
		class: className,
		constrain = false,
		coordinates = $bindable([null,null]),
		debug,
		markerClass,
		legend,
		location = $bindable(null),
		minZoom  = $bindable(0.5),
		maxZoom  = $bindable(3),
		position = $bindable({ x:0, y:0 }),
		setCoordinates,
		zoom     = $bindable(1),
        ...restProps
    } = $props()

	let history    = $state([])

	function hasMapAndChildren(location) {
		return ( location.children?.length > 0 || location.descendants?.length > 0 ) && location.map
	}

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

	function undo(id) {
		let index = history.findIndex(h => h.id === id)
		setLocation(history[index])
		history.length = index
	}

</script>




<style lang="postcss">

	:global(.map-container) {
		@apply h-full overflow-hidden w-full;

		:global(.map) {
			/* @apply relative object-cover min-h-full min-w-full overflow-hidden; */
		}
	}
	
</style>





{#snippet mapMarker(loc,i)}

	<Flex
		align="center"
		class="bg-white cursor-pointer h-6 overflow-hidden p-1 rounded-full w-6 hover:w-auto transition-all"
		style="position: absolute; left: {loc.coordinates.x}%; top: {loc.coordinates.y}%; transform: translate(-0.75rem,-50%);"
	>
		<Icon class="text-accent" name={loc.icon || "MapPin"} size="sm" weight="fill" />
		<Link
			href={route('locations.show', { location: loc.slug} )}
			class="font-style-tiny line-clamp-1 pr-1.5 text-accent truncate hover:underline"
		>{loc.name}</Link>
	</Flex>


	<!-- <div style="position: absolute; left: {loc.coordinates.x}%; top: {loc.coordinates.y}%; transform: translate(-50%,-50%);">
		<Preview
			triggerClass="flex items-center justify-center bg-white aspect-square h-6 w-6 rounded-full {markerClass}"
			href={hasMapAndChildren(loc) ? undefined : route('locations.show', { location: loc.slug})}
			icon={loc.icon || "MapPin"}
		>
			<Icon class="text-accent" name={loc.icon || "MapPin"} size="sm" weight="fill" />
			{#snippet content()}
				<Flex items="center" class="bg-white cursor-pointer px-1.5 py-1 rounded-sm z-10">
					<Link
						href={route('locations.show', { location: loc.slug} )}
						class="font-style-tiny text-accent hover:underline"
					>{loc.name}</Link>
				</Flex>
			{/snippet}
		</Preview>
	</div> -->
{/snippet}



<Flex gap={0} class="bg-white overflow-hidden rounded w-full {className}">
	
	<PanZoom
		bind:position
		bind:zoom
		constrain={constrain}
		class="bg-neutral-soft aspect-square cursor-crosshair flex-grow"
		backgroundImage="/img/grid.png"
		{minZoom} {maxZoom}
		{debug}
	{...restProps}>


		<!-- Controls -->
	
		{#snippet controls()}
			<Flex class="absolute backdrop-blur-sm hover:backdrop-blur-md bg-white/10 border border-white/50 text-white top-1.5 left-1.5 rounded-md transition-all z-10">
				{#each history as item}
					<Button style="plain" theme="neutral" label={item.name} onclick={() => undo(item.id)} />
					<Icon name="CaretRight" size="sm" />
				{/each}
				<Button style="plain" theme="neutral" size="xs" label={location?.name} class="p-1 rounded-sm" />
			</Flex>
			<Flex gap={0} class="absolute top-1.5 right-1.5 z-10">
				<Button class="w-9 rounded-l-full" style="glass" icon="MagnifyingGlassMinus" iconSize="sm" onclick={() => {zoom /= 1.2}} disabled={zoom <= minZoom} />
				<Button class="w-9 rounded-r-full" style="glass" icon="MagnifyingGlassPlus"  iconSize="sm" onclick={() => {zoom *= 1.2}} disabled={zoom >= maxZoom} />
			</Flex>
		{/snippet}
	
	
		<!-- Map Image -->
	
		<Box class="absolute map" onclick={mapClick}>
			<img class="h-full w-full" src={location.getMap()?.url} alt={location?.name} />
	
			{#if location?.children}
				{#each location?.children as location,i}
					{@render mapMarker(location,i)}
				{/each}
			{:else if location?.descendants}
				{#each location?.descendants as location,i}
					{@render mapMarker(location,i)}
				{/each}
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

	<!-- {#snippet legend()}
		<Stack class="absolute bg-white/10 border border-white/50 top-3 right-3 bottom-3 overflow-y-auto p-1 rounded w-40 backdrop-blur-md">
	
			{#if location.characters?.length > 0}
				<Inline class="border-b border-white/10 px-2 py-1.5 text-white">
					<Icon name="User" size="sm" weight="bold" />
					<span class="font-style-small font-medium">Characters</span>
					<Icon name="CaretDown" size="xs" weight="fill" class="ml-auto" />
				</Inline>
				{#each location.characters as character}
					<Inline class="px-4 py-1">
						<span class="font-style-small text-white">{character.name}</span>
					</Inline>
				{/each}
			{/if}
	
			{#if location.children?.length > 0}
				<Inline class="border-b border-white/10 px-2 py-1.5 text-white">
					<Icon name="MapPin" size="sm" weight="bold" />
					<span class="font-style-small text-white font-bold">Locations</span>
					<Icon name="CaretDown" size="xs" weight="fill" class="ml-auto" />
				</Inline>
				{#each location.children as child}
					<Inline class="px-4 py-1">
						<span class="font-style-small text-white">{child.name}</span>
					</Inline>
				{/each}
			{/if}
	
		</Stack>
	{/snippet} -->

</Flex>