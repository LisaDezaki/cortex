<script>
	import { getContext, onMount } from 'svelte';
	import Icon from '@/Components/UI/Icon.svelte'
	import clsx from 'clsx'

	let {
		class: className,
		index,
		...restProps
	} = $props()

	const {
		active,
		startDrag,
		updateDrag,
		endDrag
	} = getContext('reorder.list')

	let grabbing = $state(false)

	let startX = $state(null)
	let startY = $state(null)

	function handlePointerDown(e) {
		startX = e.clientX
		startY = e.clientY
		grabbing = true
		startDrag(e, index)

		function handlePointerMove(e) {
			updateDrag(e)
		}

		function handlePointerUp() {
			endDrag()
			startX = null
			startY = null
			grabbing = false
			window.removeEventListener('pointermove', handlePointerMove)
			window.removeEventListener('pointerup', handlePointerUp)
		}

		window.addEventListener('pointermove', handlePointerMove)
		window.addEventListener('pointerup', handlePointerUp)
	}

	onMount(() => {

	})

	let cx = $derived({
		handle: clsx('handle', {
			'cursor-grabbing': grabbing,
			'cursor-grab':    !grabbing
		}, className)
	})

</script>

<button type="button" data-drag-handle class={cx.handle} {...restProps} onpointerdown={handlePointerDown}>
	<Icon name="DotsSixVertical" size="sm" />
</button>