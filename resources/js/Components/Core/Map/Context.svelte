<script>
	import { setContext } from "svelte";
	import { writable } from "svelte/store";

	import Flex from '@/Components/Core/Flex.svelte'
	import MapLegend  from './Legend.svelte';
	import MapPreview from './Preview.svelte';

	let {
		children,
		class: className = "flex",
		location,
		previewClass = "min-h-32 w-full"
	} = $props()

	let hoveredItem   = writable(null)
	let locationStore = writable(location)

	function hoverMapMarker(item) {
		hoveredItem.set(item)
	}

	// Expose state and methods via context
	setContext("map-context", {
		hoveredItem,
		hoverMapMarker,
		location: locationStore,
		previewClass
	});

	$effect(() => {
		locationStore.set(location)
	})

</script>



<Flex class= {className}>
	{#if children}
		{@render children()}
	{:else}
		<MapPreview />
		<MapLegend />
	{/if}
</Flex>