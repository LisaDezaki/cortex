<script>
import { getContext } from 'svelte';

import Icon from '@/Components/Icon.svelte';

const { 
	startDrag, 
	updateDrag, 
	endDrag, 
	isActive 
} = getContext('reorderable-list-context');

let {
	item
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

<div
	class="drag-handle"
	bind:this={handleElement}
	onpointerdown={handlePointerDown}
>
	<Icon name="DotsSixVertical" size={24} />
</div>

<style lang="postcss">

	.drag-handle {
		cursor: grab;
		display: inline-flex;
	}

	.drag-handle:active {
		cursor: grabbing;
	}

</style>