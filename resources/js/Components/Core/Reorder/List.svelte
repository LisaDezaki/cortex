<script>
	import { onMount, setContext } from 'svelte'
	import Stack from '@/Components/Core/Stack.svelte'
	import clsx from 'clsx'

	let {
		children,
		class: className,
		items = $bindable([]),
		...restProps
	} = $props()

	let listElement
	let placeholderElement
	let itemElements = $derived(Array.from(listElement?.children) || [])

	let listRect    = $state(null)
	let itemRects   = $state(null)
	
	let activeIndex = $state(null)
	let targetIndex = $state(null)

	let mouseYStart = $state(null)
	let mouseY      = $state(null)

	setContext('reorder.list', {
		get active() { return activeIndex },
		get items()  { return items },
		startDrag(e,index) {
			mouseYStart = e.clientY
			mouseY = e.clientY
			activeIndex = index
			targetIndex = index
			itemRects = measure()
			// placeholderElement.style['height'] = itemRects[activeIndex].height+'px'
			// placeholderElement.style['width'] = itemRects[activeIndex].width+'px'
			Array.from(listElement.children).forEach((elem,index) => {
				elem.style['transition'] = index !== activeIndex ? 'transform 0.3s' : 'none'
				elem.style['z-index']    = index === activeIndex ? '10' : '1'
			})
		},
		updateDrag(e) {
			mouseY = e.clientY

			let moveUp		    = e.clientY < mouseYStart
			let moveDown		= e.clientY > mouseYStart

			//	Objectives:
			//	Determine which index is to be replaced
			//	Apply relevant classes and styles

			if (moveUp) {
				for (let i = items.length-1; i>=0; i-- ) {
					if (i <= activeIndex && e.clientY < itemRects[i].bottom) {
						targetIndex = i
					}
				}
			}

			if (moveDown) {
				for (let i = 0; i<items.length; i++) {
					if (i >= activeIndex && e.clientY > itemRects[i].top) {
						targetIndex = i
					}
				}
			}

			Array.from(listElement.children).forEach((elem,index) => {

				if (index === activeIndex) {
					elem.style['transform'] = 'translateY('+(e.clientY-mouseYStart)+'px)'
				} else if (moveUp && index < activeIndex && index >= targetIndex) {
					elem.style['transform'] = 'translateY('+itemRects[activeIndex].height+'px)'
				} else if (moveDown && index > activeIndex && index <= targetIndex) {
					elem.style['transform'] = 'translateY(-'+itemRects[activeIndex].height+'px)'
				} else {
					elem.style['transform'] = 'translateY(0)'
				}
			})

		},
		endDrag() {
			if (activeIndex !== null && targetIndex !== null) {
				items = items.toSpliced(activeIndex, 1).toSpliced(
					targetIndex,
					0,
					items[activeIndex]
				)
			}

			mouseYStart = null
			mouseY = null
			activeIndex = null
			targetIndex = null
			itemRects   = null

			Array.from(listElement.children).forEach((elem,index) => {
				console.log('element #'+index, elem)
				elem.style['transform'] = 'translateY(0)'
				elem.style['transition'] = 'none'
			})
		}
	})

	function measure() {
		return Array.from(listElement.children).map(child => child.getBoundingClientRect()) || null
	}

	onMount(() => {
		listRect = listElement.getBoundingClientRect()
		itemElements.forEach((elem,index) => {
			elem.setAttribute('data-reorder-index', index)
		})
	})

	$effect(() => {
		placeholderElement.style['height']			= activeIndex !== null ? itemRects[activeIndex].height+'px' : 0
		placeholderElement.style['width']			= activeIndex !== null ? itemRects[activeIndex].width +'px' : 0
		placeholderElement.style['top']				= targetIndex !== null ? itemRects[targetIndex].top-listRect.top+'px' : 0
	})

	let cx = {
		list: clsx('reorder list flex flex-col gap-0.5 relative', className),
		placeholder: clsx('absolute bg-lime-500 rounded'),
		item: clsx(''),
		before: clsx(''),
		after: clsx('')
	}
	
</script>



<ul bind:this={listElement} class={cx.list} {...restProps}>
	{#if items}
		{#each items as item, index (index)}
			{@render children?.({ item, index })}
		{/each}
	{:else}
		{@render children?.()}
	{/if}
	<div bind:this={placeholderElement} class={cx.placeholder}></div>
</ul>

<pre>{JSON.stringify({
	list: listRect,
	target: targetIndex ? itemRects[targetIndex] : ''
},null,3)}</pre>