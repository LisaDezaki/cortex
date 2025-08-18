<script>
	import { Box, Flex, PanZoom, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Icon from '@/Components/UI/Icon.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'
	
	let {
		class: className,
		locationTree,
        ...restProps
    } = $props()

	let activeLocation = $state(locationTree)
	let prevLocation   = $state(null)

	function setLocation(location) {
		prevLocation = activeLocation
		activeLocation = location
	}

</script>






{#snippet mapMarker(location)}
	<Flex align="center"
		class="absolute bg-white cursor-pointer h-8 px-2 rounded-full"
		onclick={() => setLocation(location)}
		style="left: {location.coordinates_x}%; top: {location.coordinates_y}%; transform: translate(-50%, -50%);"
	>
		<Icon class="text-accent" name={location.icon || "MapPin"} size="md" weight="fill" />
		<span class="font-style-button px-1">{location.name}</span>
	</Flex>
{/snippet}



<PanZoom debug constrain class="map-container bg-neutral-softest {className}" {...restProps}>

	{#snippet controls()}
		<div class="absolute top-1 right-1">
			<Button style="theme" icon="Minus" />
		</div>
	{/snippet}

	<Box class="map">
		<img src={activeLocation?.map?.url} alt={activeLocation?.name} />

		{#each activeLocation?.descendants as location}
			{@render mapMarker(location)}
		{/each}
	</Box>

</PanZoom>



<!-- STYLE -->

<style lang="postcss">

	:global(.map-container) {
		@apply relative h-full w-full overflow-hidden;

		:global(.map) {
			@apply object-cover min-h-full min-w-full overflow-hidden;
		}
	}
	
</style>