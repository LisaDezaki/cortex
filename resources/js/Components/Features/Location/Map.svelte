<script>
	import { Box, Flex, PanZoom, Stack } from '@/Components/Core'
	import Icon from '@/Components/UI/Icon.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'
	
	let {
		class: className,
		locationTree,
        ...restProps
    } = $props()

	console.log('locationTree:', locationTree)

</script>






{#snippet mapMarker(location)}
	<Flex
		class="absolute bg-white cursor-pointer h-8 w-8 rounded-full"
		style="left: {location.coordinates_x}%; top: {location.coordinates_y}%; transform: translate(-50%, -50%);"
	>
		<Icon class="text-accent" name={location.icon || "MapPin"} size="md" weight="fill" />
	</Flex>
{/snippet}



<PanZoom constrainBounds class="map-container bg-neutral-softest {className}" {...restProps}>

	<Box class="map">
		<img src="/img/world-5.png" alt={locationTree?.name} />

		{#each locationTree.descendants as location}
			{@render mapMarker(location)}
		{/each}
	</Box>

</PanZoom>



<!-- STYLE -->

<style lang="postcss">

	:global(.map-container) {
		@apply relative flex items-center justify-center h-full w-full overflow-hidden;

		:global(.map) {
			@apply object-cover min-h-full min-w-full overflow-hidden;
		}
	}
	
</style>