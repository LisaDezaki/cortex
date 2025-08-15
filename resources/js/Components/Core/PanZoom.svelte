<script>
	import { onMount } from 'svelte';

	let {
		children,
		class: className,
		contentClass,
		constrain = false,
		debug   = false,
		maxZoom = 3,
		minZoom = 1,
		zoom    = $bindable(1),
		...restProps
	} = $props();

	let containerRef
	let contentRef
	let containerRect = $state();
	let contentRect   = $state();

	let isDragging   = $state(false)
	let dragStart    = $state({ x:0, y:0 })
	let position     = $state({ x:0, y:0 })

	let minX = $derived(containerRect?.width-contentRect?.width)
	let minY = $derived(containerRect?.height-contentRect?.height)

	function clamp(min,value,max) {
		return Math.min(Math.max(value, min), max)
	}

	function updateRects() {
		containerRect = containerRef?.getBoundingClientRect();
		contentRect   = contentRef?.getBoundingClientRect();
	}

	function applyConstraints(pos) {
		if (!constrain || !containerRect || !contentRect) return pos;

		const maximumX = 0;
		const minimumX = (contentRect.width - containerRect.width)   * -(1/zoom);
		const maximumY = 0;
		const minimumY = (contentRect.height - containerRect.height) * -(1/zoom);

		return {
			x: Math.min(maximumX, Math.max(minimumX, pos.x)),
			y: Math.min(maximumY, Math.max(minimumY, pos.y))
		};
	}

	function handlePointerDown(e) {
		e.preventDefault()
		updateRects()
		isDragging = true
		dragStart = { x: e.clientX - position.x, y: e.clientY - position.y }
		const newPos = {
			x: e.clientX - dragStart.x,
			y: e.clientY - dragStart.y
		}
		position = constrain ? applyConstraints(newPos) : newPos;
		
		function handlePointerMove(e) {
			if (!isDragging) return
			const newPos = {
				x: e.clientX - dragStart.x,
				y: e.clientY - dragStart.y
			}
			position = constrain ? applyConstraints(newPos) : newPos;
		}

		function handlePointerUp() {
			isDragging = false
			window.removeEventListener('pointermove', handlePointerMove);
			window.removeEventListener('pointerup', handlePointerUp);
		}

		window.addEventListener('pointermove', handlePointerMove);
		window.addEventListener('pointerup', handlePointerUp);
	}

	function handleScroll(e) {
		e.preventDefault()
		if (e.deltaY !== null) {
			zoom *= e.deltaY < 0 ? 1.1 : 0.9
			zoom = clamp(minZoom, zoom, maxZoom)
			setTimeout(updateRects,10)
			position = constrain ? applyConstraints(position) : position;
		}
	}

	onMount(() => {
		updateRects();
		position = constrain ? applyConstraints(position) : position;
	});

</script>

<div bind:this={containerRef}
	class="relative {className}"
	class:cursor-grab={!isDragging}
	class:cursor-grabbing={isDragging}
	onwheel={handleScroll}
{...restProps}>
	{#if debug}
		<ul class="absolute top-1 left-1 backdrop-blur-sm bg-white/15 p-1 pointer-events-none rounded text-xs text-danger z-10">
			<!-- <li class="">
				constrain: {constrain}
			</li> -->
			<!-- <li class="">
				isDragging: {isDragging}
			</li> -->
			<!-- <li class="">
				dragStart: {dragStart.x}, {dragStart.y}
			</li> -->
			<li class="">
				zoom: {zoom*100}%
			</li>
			<li class="">
				position: {position.x}, {position.y}
			</li>
			<li class="">
				contentSize: {contentRect?.width}, {contentRect?.height}
			</li>
			<li class="">
				containerSize: {containerRect?.width}, {containerRect?.height}
			</li>
			<li class="">
				minXY: {minX}, {minY}
			</li>
		</ul>
	{/if}
	<div bind:this={contentRef}
		class="draggable {contentClass}"
		style="transform: scale({zoom}) translate({position.x}px, {position.y}px); transform-origin: 0 0;"
		onpointerdown={handlePointerDown}
	>
		{@render children?.()}
	</div>

	<div class="absolute border border-lime-500 inset-0 pointer-events-none"></div>
</div>