<script>
	import { onMount } from "svelte";
	import { writable, get } from "svelte/store";

	let {
		children,
		class: className,
		constrain = false,
		initialPosition = null,
		initialZoom = 1,
		minZoom = 0.5,
		maxZoom = 4,
		...restProps
	} = $props()

	const zoom = writable(initialZoom);
	const offset = writable({ x: 0, y: 0 });

	let containerEl;
	let contentEl;

	// Drag state
	let isDragging = false;
	let start = { x: 0, y: 0 };
	let startOffset = { x: 0, y: 0 };

	// Touch pinch state
	let pinchStartDist = 0;
	let pinchStartZoom = 1;

	onMount(() => {
		// Center content if initialPosition is not provided
		if (!initialPosition) {
			centerContent();
		} else {
			offset.set(initialPosition);
		}
	});

	function centerContent() {
		const cw = containerEl.clientWidth;
		const ch = containerEl.clientHeight;
		const iw = contentEl.clientWidth;
		const ih = contentEl.clientHeight;
		const z = get(zoom);

		offset.set({
			x: (cw - iw * z) / 2,
			y: (ch - ih * z) / 2
		});
	}

	function onWheel(e) {
		if (e.ctrlKey || e.deltaY % 1 !== 0) {
			// Trackpad pinch OR ctrl+wheel
			e.preventDefault();
			const zoomAmount = -e.deltaY * 0.001;
			setZoom(get(zoom) * (1 + zoomAmount), e.clientX, e.clientY);
		}
	}

	function setZoom(newZoom, centerX, centerY) {
		const clamped = Math.min(maxZoom, Math.max(minZoom, newZoom));

		if (centerX != null && centerY != null) {
			// Zoom towards pointer position
			const prevZoom = get(zoom);
			const scale = clamped / prevZoom;

			const o = get(offset);
			const rect = containerEl.getBoundingClientRect();
			const offsetX = centerX - rect.left;
			const offsetY = centerY - rect.top;

			offset.set({
				x: offsetX - scale * (offsetX - o.x),
				y: offsetY - scale * (offsetY - o.y)
			});
		}

		zoom.set(clamped);
		if (constrain) applyConstraints();
	}

	function onMouseDown(e) {
		isDragging = true;
		start = { x: e.clientX, y: e.clientY };
		startOffset = get(offset);
		window.addEventListener("mousemove", onMouseMove);
		window.addEventListener("mouseup", onMouseUp);
	}

	function onMouseMove(e) {
		if (!isDragging) return;
		const dx = e.clientX - start.x;
		const dy = e.clientY - start.y;
		offset.set({
			x: startOffset.x + dx,
			y: startOffset.y + dy
		});
		if (constrain) applyConstraints();
	}

	function onMouseUp() {
		isDragging = false;
		window.removeEventListener("mousemove", onMouseMove);
		window.removeEventListener("mouseup", onMouseUp);
	}

	// Touch events
	function onTouchStart(e) {
		if (e.touches.length === 1) {
			isDragging = true;
			start = { x: e.touches[0].clientX, y: e.touches[0].clientY };
			startOffset = get(offset);
		} else if (e.touches.length === 2) {
			isDragging = false;
			pinchStartDist = getTouchDist(e);
			pinchStartZoom = get(zoom);
		}
	}

	function onTouchMove(e) {
		if (e.touches.length === 1 && isDragging) {
			const dx = e.touches[0].clientX - start.x;
			const dy = e.touches[0].clientY - start.y;
			offset.set({
				x: startOffset.x + dx,
				y: startOffset.y + dy
			});
			if (constrain) applyConstraints();
		} else if (e.touches.length === 2) {
			const newDist = getTouchDist(e);
			const scale = newDist / pinchStartDist;
			setZoom(pinchStartZoom * scale);
		}
	}

	function onTouchEnd(e) {
		if (e.touches.length === 0) {
			isDragging = false;
		}
	}

	function getTouchDist(e) {
		const dx = e.touches[0].clientX - e.touches[1].clientX;
		const dy = e.touches[0].clientY - e.touches[1].clientY;
		return Math.sqrt(dx * dx + dy * dy);
	}

	function applyConstraints() {
		const z = get(zoom);
		const o = { ...get(offset) };
		const cw = containerEl.clientWidth;
		const ch = containerEl.clientHeight;
		const iw = contentEl.clientWidth;
		const ih = contentEl.clientHeight;
		const sw = iw * z;
		const sh = ih * z;

		if (sw <= cw) {
			o.x = (cw - sw) / 2;
		} else {
			o.x = Math.min(0, Math.max(o.x, cw - sw));
		}
		if (sh <= ch) {
			o.y = (ch - sh) / 2;
		} else {
			o.y = Math.min(0, Math.max(o.y, ch - sh));
		}
		offset.set(o);
	}
</script>

<style>
	.pan-container {
		position: relative;
		overflow: hidden;
		width: 100%;
		min-height: 20rem;
		touch-action: none; /* important for touch pan/zoom */
		user-select: none;
	}
	.pan-content {
		position: absolute;
		top: 0;
		left: 0;
		transform-origin: 0 0;
	}
</style>

<div
	class="pan-container"
	bind:this={containerEl}
	onwheel={onWheel}
	onmousedown={onMouseDown}
	ontouchstart={onTouchStart}
	ontouchmove={onTouchMove}
	ontouchend={onTouchEnd}
>
	<div
		class="pan-content"
		bind:this={contentEl}
		style="transform: translate({$offset.x}px, {$offset.y}px) scale({$zoom});"
	>
		<slot />
	</div>
</div>