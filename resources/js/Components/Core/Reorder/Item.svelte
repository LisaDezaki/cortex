<script>
	import { setContext, getContext } from 'svelte';
	import { LIST_CONTEXT, ITEM_CONTEXT } from './context.js';
	// import Reorder from './Base.svelte'
	import Flex from '@/Components/Core/Flex.svelte'
	import clsx from 'clsx'

	let {
		children,
		class: className,
		index,
		itemIndex,
		...restProps
	} = $props()

	const listContext = getContext(LIST_CONTEXT)

	setContext(ITEM_CONTEXT, {
		get itemIndex() { return itemIndex },
		get index() { return index },
		get isDragging() { return listContext.draggingIndex() === index },
		get isDragOver() { return listContext.draggingOverIndex() === index },
		dragStart: () => listContext.startDragging(index),
		dragEnd: () => listContext.stopDragging(),
		dragOver: () => listContext.setDraggingOver(index),
		reorder: (toIndex) => listContext.reorder(index, toIndex)
	})

	//	Derived values for local use
	const isDragging = $derived(listContext.draggingIndex() === index)
	const isDragOver = $derived(listContext.draggingOverIndex() === index)

	let cx = {
		item: clsx('item', className)
	}

</script>

<Flex as="li" align="center" class={cx.item} {...restProps}>
	{@render children?.()}
</Flex>