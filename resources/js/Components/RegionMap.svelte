<!-- SCRIPT -->
 
<script>

	import Icon from '@/Components/Icon.svelte'
	import Thumbnail from '@/Components/Thumbnail.svelte'
	
	let {
		class: className,
		region,
        ...attrs
    } = $props()

</script>



<!-- STRUCTURE -->

<div class="relative flex gap-2 w-full">

	<div class="map relative flex-grow bg-slate-100 border border-slate-200 rounded-lg overflow-hidden max-w-[50%]">
		<img
			src={region.map_path}
			alt={region.name}
		/>
		{#each region.locations as location}
			<Thumbnail
				class="map-pin absolute w-8 border border-white"
				style="left: {location.coordinates.x}; top: {location.coordinates.y};"
				icon="MapPin"
				src={location.banner_path}
				alt={location.name}
			/>
		{/each}
	</div>

	<ul class="p-2 w-48">
		{#each region.locations as location, i}
			<li class="flex items-center gap-1 hover:text-emerald-500 truncate">
				{i+1}. {location.name}
			</li>
		{/each}
	</ul>

</div>



<!-- STYLE -->

<style lang="postcss">

	:global(.map-pin) {
		@apply absolute;
	}
	
</style>