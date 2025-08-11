<script>
	import { getContext } from "svelte";

	const { files, clearFiles } = getContext("file-upload-context");

	let {
		children,
		class: className
	} = $props();

	function getPreviewUrl(file) {
		return URL.createObjectURL(file);
	}
</script>

<div class="upload-preview relative {className}">

	<div class="absolute flex items-center justify-center">
		{#each $files as file}
			<img src={getPreviewUrl(file)} alt={file.name} class="preview-image" />
		{/each}
	</div>

	{@render children(files, clearFiles)}

</div>

<style lang="postcss">
	.upload-preview {
		@apply overflow-hidden;
		background-color: var(--bg-neutral-softest);
	}
</style>