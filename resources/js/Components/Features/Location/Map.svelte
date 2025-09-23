<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	import { Box, Flex, Inline, PanZoom, Preview, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Icon from '@/Components/UI/Icon.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

	let worldTree = $page.props.worldTree?.data
	
	let {
		class: className,
		markerClass,
		constrain = false,
		legend,
		location = $bindable(worldTree || null),
		minZoom  = $bindable(0.5),
		maxZoom  = $bindable(3),
		position = $bindable({ x:0, y:0 }),
		zoom     = $bindable(1),
        ...restProps
    } = $props()

	let history = $state([])

	let media_map = $derived(location?.media?.filter(m => m.type === 'map')?.[0])

	function setLocation(loc) {
		history = [ ...history, location ]
		location = loc
	}

	function hasMapAndChildren(location) {
		return ( location.children?.length > 0 || location.descendants?.length > 0 ) && location.map
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
	<div style="position: absolute; left: {loc.coordinates.x}%; top: {loc.coordinates.y}%; transform: translate(-50%,-50%);">
		<Preview
			triggerClass="flex items-center justify-center bg-white aspect-square cursor-pointer h-8 w-8 rounded-full {markerClass}"
			href={hasMapAndChildren(loc) ? undefined : route('locations.show', { location: loc.slug})}
			icon={loc.icon || "MapPin"}
		>
			<Icon class="text-accent" name={loc.icon || "MapPin"} size="md" weight="fill" />
			{#snippet content()}
				<Flex items="center" class="bg-white rounded-lg z-10">
					<Thumbnail class="rounded-l-lg rounded-r-none w-20" src={loc.banner?.url} />
					<Flex align="start" justify="center" gap={0} direction="col" class="px-2 py-1.5 pr-3 rounded-lg">
						<span class="text-md">{loc.name}</span>
						<span class="text-sm">{loc.alias}</span>
						<Flex class="mt-auto" gap={2}>
							<Link href={route('locations.show', { location: loc.slug} )} class="italic text-accent text-sm hover:underline">Go to Location</Link>
							{#if loc.map}
								<button onclick={() => setLocation(loc)} class="italic text-accent text-sm hover:underline">View Map</button>
							{/if}
						</Flex>
					</Flex>
				</Flex>
			{/snippet}
		</Preview>
	</div>
{/snippet}




<Flex gap={0} class="bg-white overflow-hidden rounded w-full {className}">
	

	<PanZoom
		bind:position
		bind:zoom
		constrain={constrain}
		class="bg-neutral-soft aspect-square flex-grow"
		backgroundImage="/img/grid.png"
		{minZoom} {maxZoom}
		debug={{ location: location?.name }}
	{...restProps}>


		<!-- Controls -->
	
		{#snippet controls()}
			<Flex class="absolute backdrop-blur-sm hover:backdrop-blur-md bg-white/10 border border-white/50 text-white top-3 left-3 z-10 px-2 rounded-full transition-all">
				{#each history as item}
					<Button style="plain" theme="neutral" label={item.name} onclick={() => undo(item.id)} />
					<Icon name="CaretRight" size="sm" />
				{/each}
				<Button style="plain" theme="neutral" label={location?.name} />
			</Flex>
			<Flex gap={0.5} class="absolute top-3 right-3 z-10">
				<Button class="w-10 rounded-l-full" style="glass" icon="MagnifyingGlassMinus" iconSize="sm" onclick={() => {zoom /= 1.2}} disabled={zoom <= minZoom} />
				<Button class="w-10 rounded-r-full" style="glass" icon="MagnifyingGlassPlus"  iconSize="sm" onclick={() => {zoom *= 1.2}} disabled={zoom >= maxZoom} />
			</Flex>
		{/snippet}
	
	
		<!-- Map Image -->
	
		<Box class="absolute map">
			<img class="h-full w-full" src={media_map?.url} alt={media_map?.name} />
	
			{#if location?.children}
				{#each location?.children as location,i}
					{@render mapMarker(location,i)}
				{/each}
			{:else if location?.descendants}
				{#each location?.descendants as location,i}
					{@render mapMarker(location,i)}
				{/each}
			{/if}
		</Box>
	
	</PanZoom>
	
	
	<!-- Points of Interest -->

	{#if legend}
		<Stack class="h-full p-1 pr-1.5 rounded-r shrink-0 w-48 backdrop-blur-md overflow-y-auto">
			{#each legend as item}
				<Inline class="px-2 py-1.5 w-full pr-3">
					<Icon name={item.icon} size="sm" weight="bold" />
					<span class="font-style-small font-medium line-clamp-1">{item.label}</span>
					<Icon name="CaretDown" size="xs" weight="fill" class="ml-auto" />
				</Inline>
				{#if item.items?.length > 0}
					<Stack class="py-1">
						{#each item.items as subitem}
							<Inline class="cursor-pointer px-2 py-1 rounded w-full hover:bg-neutral-softest">
								{#if subitem.image}
									<Thumbnail class="h-6 w-6" src={subitem.image?.url} />
								{:else}
									<Icon class="h-6 w-6 text-accent" name={subitem.icon} size="md" />
								{/if}
								<span class="font-style-small font-medium line-clamp-1">{subitem.label}</span>
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