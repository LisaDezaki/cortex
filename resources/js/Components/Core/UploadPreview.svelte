<script>
	import { getContext } from "svelte";
	import Icon from '@/Components/UI/Icon.svelte'

	const { files, getFiles, clearFiles, media, processing } = getContext("file-upload-context");

	let {
		children,
		class: className,
		imageClass,
		index
	} = $props();
</script>





{#if index !== null}
	<div class="upload-preview bg-neutral-softest min-h-56 {className}">

		{#if $processing}
			<Icon class="absolute top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%] bg-accent-softest p-1 rounded-full text-accent" animation="animate-spin" name="CircleNotch" size="xl" />
		{:else if media}
			<img src={media?.url} class={imageClass} alt="Preview of the uploaded file" />
		{:else if getFiles()?.[0]}
			<img src={getFiles()[0].url} class={imageClass} alt="Preview of the uploaded file" />
		{:else}
			<div class={imageClass}>
				<Icon name="Image" size="xl" weight="light" />
			</div>
		{/if}

		{@render children?.(files, clearFiles)}
		
	</div>
{/if}