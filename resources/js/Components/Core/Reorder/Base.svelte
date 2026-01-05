<script>
	import { setContext } from 'svelte';
	import Box from '@/Components/Core/Box.svelte'
    import clsx from 'clsx'

	//	Unique keys for context
	export const LIST_CONTEXT = Symbol()
	export const ITEM_CONTEXT = Symbol()

	let {
		children,
		class: className,
		items = [],
		...restProps
	} = $props()

	let draggingIndex	  = $state(null)
	let draggingOverIndex = $state(null)
	let order = $state([])

	//	Initialize order on mount
	$effect(() => {
		if (items.length > 0) {
			order = item.map((_,i) => i)
		}
	})

	let activeId = $state(null)
	let targetId = $state(null)

	setContext(LIST_CONTEXT, {
		get items() { return items },
		get order() { return order },
		get draggingIndex() { return draggingIndex },
		get draggingOverIndex() { return draggingOverIndex },
		startDrag: (e, item) => {
			activeId = item?.id || item,
			targetId = item?.id || item
		},
		updateDrag: (e, item) => {

		},
		endDrag: (e, item) => {
			activeId    = null;
			targetId    = null;
		},
		isActive: (item) => {}
	})

	let cx = {
		reorder: clsx('reorder content relative', className)
	}

</script>

{@render children?.({order})}