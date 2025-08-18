<script>
	import { onMount } from 'svelte';

	let {
		children,
		class: className,
		contentClass,
		controls,
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
	let clickStart   = $state({ x:0, y:0 })
	let dragVector   = $state({ x:0, y:0 })
	let moveVector   = $state({ x:0, y:0 })
	let origin       = $state({ x:0, y:0 })
	let position     = $state({ x:0, y:0 })
	let transform    = $state({ x:0, y:0 })

	let containerWidth = $state(null)
	let contentWidth   = $state(null)

	let constrainX = $state({ min:0, max:0 })
	let constrainY = $state({ min:0, max:0 })

	// let minX = $derived( -(contentRect?.right-containerRect?.right) )
	// let maxX = $derived(  (containerRect?.left-contentRect?.left) )
	// let minY = $derived( -(contentRect?.bottom-containerRect?.bottom) )
	// let maxY = $derived(  (containerRect?.top-contentRect?.top) )

	function clamp(min,value,max) {
		return Math.min(Math.max(value, min), max)
	}

	function dragStart(e) {
		e.preventDefault()
		isDragging = true
		clickStart = { x: e.clientX, y: e.clientY }
		if (constrain) {
			updateRects()
			constrainX.min = -(contentRect?.right-containerRect?.right)
			constrainX.max =  (containerRect?.left-contentRect?.left)
			constrainY.min = -(contentRect?.bottom-containerRect?.bottom)
			constrainY.max =  (containerRect?.top-contentRect?.top)
		}
		window.addEventListener('pointermove', dragUpdate);
		window.addEventListener('pointerup', dragEnd);
	}

	function dragUpdate(e) {
		if (!isDragging) return
		dragVector.x = (e.clientX-clickStart.x)
		dragVector.y = (e.clientY-clickStart.y)
		transform.x = constrain ? clamp(constrainX.min, dragVector.x, constrainX.max) : dragVector.x
		transform.y = constrain ? clamp(constrainY.min, dragVector.y, constrainY.max) : dragVector.y
	}

	function dragEnd() {
		isDragging = false
		updateRects()
		position.x = position.x + transform.x
		position.y = position.y + transform.y
		clickStart = { x:0, y:0 }
		dragVector = { x:0, y:0 }
		transform  = { x:0, y:0 }
		constrainX = { min:0, max:0 }
		constrainY = { min:0, max:0 }
		window.removeEventListener('pointermove', dragUpdate);
		window.removeEventListener('pointerup', dragEnd);
	}

	function handleScroll(e) {
		e.preventDefault()
		origin = { x: e.clientX, y: e.clientY }
		if (e.deltaY !== null) {
			zoom *= e.deltaY < 0 ? 1.05 : 0.95
			zoom = clamp(minZoom, zoom, maxZoom)
			setTimeout(applyConstraints,10)
		}
	}








	function updateRects() {
		containerRect  = containerRef?.getBoundingClientRect()
		contentRect    = contentRef?.getBoundingClientRect()
	}

	function applyConstraints() {
		updateRects()
		if (!constrain || !containerRect || !contentRect) return;

		constrainX.min = -(contentRect?.right-containerRect?.right)
		constrainX.max =  (containerRect?.left-contentRect?.left)
		constrainY.min = -(contentRect?.bottom-containerRect?.bottom)
		constrainY.max =  (containerRect?.top-contentRect?.top)

		if (constrainX.max < 0) {
			position.x += constrainX.max
		}
		// if (constrainX.min > 0) {
		// 	position.x -= constrainX.min
		// }
		// if (constrainY.min > 0) {
		// 	position.y -= constrainY.min
		// }
		if (constrainY.max < 0) {
			position.y += constrainY.max
		}


	}

	

	

	onMount(() => {
		setTimeout(applyConstraints,10)
	});

</script>















<div bind:this={containerRef}
	class="relative overflow-hidden {className}"
	class:cursor-grab={!isDragging}
	class:cursor-grabbing={isDragging}
	onwheel={handleScroll}
{...restProps}>
	{#if debug}
		<ul class="absolute top-1 left-1 backdrop-blur-sm bg-white/15 p-1 pointer-events-none rounded text-xs text-white z-10">
			<li class="">
				constraints: X:{Math.floor(constrainX.min)}-{Math.floor(constrainX.max)}, Y:{Math.floor(constrainY.min)}-{Math.floor(constrainY.max)}
			</li>
			<!-- <li class="">
				isDragging: {isDragging}
			</li> -->
			<!-- <li class="">
				clickStart: {Math.floor(clickStart.x)}, {Math.floor(clickStart.y)}
			</li> -->
			<li class="">
				dragVector: {Math.floor(dragVector.x)}, {Math.floor(dragVector.y)}
			</li>
			<li class="">
				zoom: {Math.floor(zoom*100)}%
			</li>
			<li class="">
				transform: {Math.floor(transform.x)}, {Math.floor(transform.y)}
			</li>
			<li class="">
				position: {Math.floor(position.x)}, {Math.floor(position.y)}
			</li>
			<!-- <li class="">
				containerWidth: {containerWidth}
			</li> -->
			<!-- <li class="">
				contentWidth: {contentWidth}
			</li> -->
			<!-- <li class="">
				contentWidth*zoom: {Math.floor(contentWidth*zoom)}
			</li> -->
			
			<!-- <li class="">
				constraintsX: {Math.floor(minX)}, {Math.floor(maxX)}
			</li> -->
			<!-- <li class="">
				constraintsY: {Math.floor(minY)}, {Math.floor(maxY)}
			</li> -->
		</ul>
	{/if}

	{#if controls}
		<div class="absolute inset-0">
			{@render controls()}
		</div>
	{/if}

	<div bind:this={contentRef}
		class="draggable {contentClass}"
		style="transform: scale({zoom}) translate({(position.x+transform.x)/zoom}px, {(position.y+transform.y)/zoom}px); transform-origin: {origin.x}px {origin.y}px"
		onpointerdown={dragStart}
	>
		{@render children?.()}
	</div>

</div>