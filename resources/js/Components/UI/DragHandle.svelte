<script>
import { getContext } from 'svelte';

import Flex from '@/Components/Core/Flex.svelte';
import Icon from '@/Components/UI/Icon.svelte';

const { 
	startDrag, 
	updateDrag, 
	endDrag, 
	isActive 
} = getContext('reorderable-list-context');

let {
	item,
	size = 'md'
} = $props();

let handleElement;
let startX = $state(null);
let startY = $state(null);

function handlePointerDown(e) {
	e.stopPropagation();
	e.preventDefault();
	startX = e.clientX;
	startY = e.clientY;
	startDrag(e, item);

	function handlePointerMove(e) {
		updateDrag(e, item);
	}

	function handlePointerUp() {
		endDrag();
		window.removeEventListener('pointermove', handlePointerMove);
		window.removeEventListener('pointerup', handlePointerUp);
	}

	window.addEventListener('pointermove', handlePointerMove);
	window.addEventListener('pointerup', handlePointerUp);
}
</script>

<Flex align="center" justify="center"
	class="drag-handle"
	bind:this={handleElement}
	onpointerdown={handlePointerDown}
>
	<Icon name="DotsSixVertical" size={size} weight="bold" />
</Flex>

<style lang="postcss">

	:global(.drag-handle) {
		cursor: grab;
		display: inline-flex;
		&:active {
			cursor: grabbing;
		}
	}

</style>