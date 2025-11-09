<script>
	import { setContext } from "svelte";

	import Flex from '@/Components/Core/Flex.svelte'
	import MapLegend  from './Legend.svelte';
	import MapPreview from './Preview.svelte';

	let {
		children,
		class: className = "flex",
		location,
		legendClass = "",
		previewClass = "min-h-32 w-full",
		onUpload,
		pannable = false,
		zoomable = false
	} = $props()

	let activeItem	= $state(null)
	let hoveredItem	= $state(null)
	let lastClick	= $state({x:null,y:null})

	function handleFileUpload(e) {
		onUpload()
	}

	function handleItemHover(item) {
		hoveredItem = item
	}

	function handleConfirmCoordinates() {
		location.addMapMarker([{
			mappable_id:   activeItem.mappable.id,
			mappable_type: activeItem.type,
			x: lastClick.x,
			y: lastClick.y
		}])
	}

	function handlePreviewClick(e) {
		lastClick = {
			x: 100 / e.target.width  * e.layerX,
			y: 100 / e.target.height * e.layerY
		}
	}

	function setActiveItem(item) {
		// console.log('MapContext.setActiveItem()', item)
		activeItem = item
	}

	console.log(location)

	// Expose state and methods via context
	setContext("map-context", {
		getActive:	 () => activeItem,
		getHovered:  () => hoveredItem,
		getItems:    () => location.mapItems,
		getLastClick:() => lastClick,
		getLocation: () => location,
		getMap:		 () => location.getMedia?.('map'),
		handleConfirmCoordinates,
		handleFileUpload,
		handleItemHover,
		handlePreviewClick,
		setActiveItem,
		legendClass,
		previewClass,
		pannable,
		zoomable
	});

</script>



<!-- <pre>{JSON.stringify({
	lastClick,
	activeItem:  activeItem?.mappable?.id  || 'null',
	hoveredItem: hoveredItem?.mappable?.id || 'null'
}, null, 3)}</pre> -->

<Flex class= {className}>
	{#if children}
		{@render children()}
	{:else}
		<MapPreview class={previewClass} />
		<MapLegend  class={legendClass}  />
	{/if}
</Flex>