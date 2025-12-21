<script>
	import { setContext } from 'svelte';

	let {
		items,
		itemTemplate
	} = $props();

	let listElement;
	let placeholderElement;

	let activeId    = $state(null)
	let targetId    = $state(null)
	
	let dragStartY  = $state(null)
	let itemRects   = new Map();
	let listTop     = $state(null) 
	let listBottom  = $state(null)
	let mouseY      = $state(null)

	let activeIndex = $derived(items.findIndex(item => item.id === activeId))
	let targetIndex = $derived(items.findIndex(item => item.id === targetId))

	const context = {
		startDrag: (e, item) => {

			activeId   = item?.id || item
			targetId   = item?.id || item

			dragStartY = e.clientY
			itemRects  = measureItems()
			listTop    = listElement.getBoundingClientRect().top
			listBottom = listElement.getBoundingClientRect().bottom
			mouseY     = e.clientY;

			setPlaceholder()
			listElement.setAttribute('data-active', true)
		},
		updateDrag: (e, item) => {

			mouseY = e.clientY

			//	Dragging downwards
			if (activeIndex !== items.length-1 && mouseY > dragStartY) {
				items.filter((item,i) => i >= activeIndex).forEach((item) => {
					let rect  = itemRects.get(item.id)
					if (e.clientY > rect.top) {
						targetId = item.id
					}
				})
			}

			//	Dragging upwards
			if (activeIndex !== 0 && mouseY < dragStartY) {					
				items.filter((item,i) => i <= activeIndex).reverse().forEach((item) => {
					let rect  = itemRects.get(item.id)
					if (e.clientY < rect.bottom) {
						targetId = item.id
					}
				})
			}

			setPlaceholder()
		},
		endDrag: () => {

			if (activeId && targetId && activeId !== targetId) {
				items = items.toSpliced(activeIndex, 1).toSpliced(
					targetIndex,
					// targetIndex > activeIndex ? targetIndex - 1 : targetIndex,
					0,
					items[activeIndex]
				)
			}

			activeId    = null;
			targetId    = null;

			dragStartY  = null;
			listTop     = null;
			listBottom  = null;
			mouseY      = null;
			
			itemRects   = new Map();
			listElement.setAttribute('data-active', false)

		},
		isActive: (item) => activeId === item.id
	}

	setContext('reorderable-list-context', context);

	$effect(() => {
		const handlePointerUp = () => {
			// activeId = null;
		};

		window.addEventListener('pointerup', handlePointerUp);
		return () => window.removeEventListener('pointerup', handlePointerUp);
	});

	function measureItems() {
		if (!listElement) return;

		const newRects = new Map();
		const children = listElement.querySelectorAll('[data-id]');

		children.forEach(child => {
			const child_id = child.getAttribute('data-id');
			newRects.set(child_id, child.getBoundingClientRect());
		});
		
		return newRects;
	}

	function setPlaceholder() {
		// let targetId = items[targetIndex].id
		let offsetTop    = itemRects.get(targetId).top - listTop
		let offsetBottom = listBottom - itemRects.get(targetId).bottom
		placeholderElement.style['top']    = offsetTop+"px"
		placeholderElement.style['bottom'] = offsetBottom+"px"
	}

	function shouldShift(item) {
		let index = items.indexOf(item)
		let rect  = itemRects.get(item.id)
		if (!rect || index === activeIndex) {
			return false;
		}
		if ( ( (index > activeIndex) && (mouseY > rect.top) ) || ( (index < activeIndex) && (mouseY < rect.bottom) ) ) {
			return true
		}
	}

</script>

<div bind:this={listElement} class="reorderable-list" class:active={activeId}>
	{#each items as item, index (item?.id || index+item)}
		<div
			data-id={item.id}
			class="reorderable-item"
			class:active={activeId === item.id}
			class:before={activeId && items.indexOf(item) < activeIndex}
			class:after={ activeId && items.indexOf(item) > activeIndex}
			class:shift={ shouldShift(item) }
			style:transform={activeId === item.id ? `translateY(${mouseY - dragStartY}px)` : ""}
		>
			{@render itemTemplate(item, index)}
		</div>
	{/each}
	<div bind:this={placeholderElement} class="reorderable-placeholder"></div>
</div>

<style lang="postcss">

	.reorderable-list {
		@apply relative flex flex-col;
		/* outline: 1px solid red; */
		&.active {
			/* outline: 1px solid lime; */
		}

		.reorderable-item {
			@apply rounded-lg shadow-none transition-shadow;
			transform: translateY(0);
			z-index: 1;
			&.active {
				@apply shadow-lg;
				background-color: var(--bg-white);
				z-index: 10;
			}

			&.before.shift {
				transform: translateY(100%);
			}

			&.after.shift {
				transform: translateY(-100%);
			}
		}

		.reorderable-placeholder {
			background-color: transparent;
			@apply absolute inset-0 rounded-lg pointer-events-none;
			z-index: 0;
		}

		&.active .reorderable-placeholder {
			background-color: var(--bg-neutral-softest);
			@apply absolute inset-0 rounded-lg pointer-events-none;
			z-index: 0;
			box-shadow: inset  1px  1px 0 var(--shadow-lowlight),
						inset -1px -1px 0 var(--shadow-highlight);
		}
	}

</style>