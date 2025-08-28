<script>
	import { getContext } from "svelte";

	const { files, getFiles, clearFiles } = getContext("file-upload-context");

	import { Box, Flex, Grid }      from '@/Components/Core'
	import UploadTrigger from './UploadTrigger.svelte'
	import Button		 from '@/Components/UI/Button.svelte'
	import Icon		 	 from '@/Components/UI/Icon.svelte'
	import MediaGrid	 from '@/Components/UI/MediaGrid.svelte'

	let {
		children,
		class: className,
		imageClass,
		index
	} = $props();

	// let previewUrl = $derived(media?.url || `/storage/${media?.path}` || null)

	// function getPreviewUrl(file) {
	// 	return URL.createObjectURL(file);
	// }
</script>



{#if index !== null}
	<div class="upload-preview bg-neutral-softest min-h-40 {className}">

		 <!-- getFiles()[index] -->

		{#if getFiles()[index]}
			<img src={getFiles()[index].url} alt={getFiles()[index].url} class={imageClass} />
		{:else}
			<div class={imageClass}>
				<Icon name="Image" size="xl" weight="light" />
			</div>
		{/if}

		<!-- {#if isMultiple()}
			<MediaGrid addable cols={4} media={getValue()}>
				{#snippet add()}
					<UploadTrigger class="aspect-square bg-accent-softest border border-accent-softest text-accent w-full"
						icon="Plus"
					/>
				{/snippet}
			</MediaGrid>
		{:else}
			<Box>
				<img class="preview-image {imageClass}"
					src="/storage/{getValue()}" alt="Preview"
				/>
				<UploadTrigger class="aspect-square bg-accent-softest border border-accent-softest rounded-lg text-accent w-full"
					icon="UploadSimple"
				/>
			</Box>
		{/if} -->

		{@render children?.(files, clearFiles)}

	</div>
{/if}