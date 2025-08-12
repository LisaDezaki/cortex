<script>
	import { getContext } from "svelte";

	const { files, clearFiles } = getContext("file-upload-context");

	let {
		children,
		class: className,
		layoutClass,
		imageClass,
	} = $props();

	function getPreviewUrl(file) {
		return URL.createObjectURL(file);
	}
</script>

<div class="upload-preview relative {className}">

	<div class="absolute inset-0 grid grid-cols-{$files.length || 1} gap-1.5 justify-center {layoutClass}">
		{#each $files as file}
			<img src={getPreviewUrl(file)} alt={file.name} class="preview-image {imageClass}" />
		{/each}
	</div>

	{@render children?.(files, clearFiles)}

</div>

<style lang="postcss">
	.upload-preview {
		@apply min-h-16 min-w-16 overflow-hidden w-full;
		background-color: var(--bg-neutral-softest);

		.preview-image {
			@apply object-cover min-h-full min-w-full;
		}
	}
</style>