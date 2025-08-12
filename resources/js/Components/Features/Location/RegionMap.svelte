<script>
	import { Flex, Stack } from '@/Components/Core'
	import Icon from '@/Components/UI/Icon.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'
	
	let {
		class: className,
		region,
        ...restProps
    } = $props()

</script>



<!-- STRUCTURE -->

<Flex gap={3} class="relative mb-12 w-full" {...restProps}>

	<div class="map relative flex-grow bg-slate-100 border border-slate-200 rounded-lg max-w-[50%]">
		<img
			src={region.map_path}
			alt={region.name}
		/>
		{#each region.locations as location}
			<Thumbnail
				class="map-pin absolute w-8"
				style="left: {location.coordinates.x}%; top: {location.coordinates.y}%;"
				icon="MapPin"
				src={location.banner_path}
				alt={location.name}
			/>
		{/each}
	</div>

	<Stack as="ul" class="p-2 w-48">
		{#each region.locations as location, i}
			<Flex as="li" align="center" gap={1.5} class="truncate cursor-pointer hover:text-emerald-500">
				{i+1}. {location.name}
			</Flex>
		{/each}
	</Stack>

</Flex>



<!-- STYLE -->

<style lang="postcss">

	.map {
		@apply min-h-72 p-2 text-xs;
		background-color: var(--bg-neutral-softest);
		/* border-color: var(--border-neutral-softest); */
		color: var(--text-neutral-softest);
	}

	:global(.map-pin) {
		@apply absolute cursor-pointer shadow;
		background-color: var(--bg-white);
	}
	
</style>