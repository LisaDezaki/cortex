<script>
	/**
	 * UI Component
	 * MEDIA GRID
	 * 
	 * Displays a collection of files (usually images) in a grid with a
	 * user-defined number of columns.
	 * 
	 * Props:
	 * 	addable: boolean
	 *  	The "addable" prop defines whether the grid should display an
	 * 		"add more" button after the media items.
	 * 
	 * 	media: array
	 * 		The list of media items to display in this grid. Media items are
	 * 		expected to be structured according to the Media Resource, found
	 * 		at app/Http/Resources/MediaResource.php
	 * 
	 * 	onAdd: function
	 * 		The onAdd prop should contain a callback function from the parent
	 * 		to handle the button click. This only applies if 'addable' is true.
	 */

	import MediaUploadForm from '@/Forms/Media/MediaUploadForm.svelte'
	import { Flex, Grid } from '@/Components/Core'
	import Button	from '@/Components/UI/Button.svelte'
	import Icon		from '@/Components/UI/Icon.svelte'
	import Media	from '@/Components/UI/Media.svelte'
	import Modal	from '@/Components/UI/Modal.svelte'

	let {
		add,
		addable = false,
		aspect,
		class: className,
		cols = 4,
		gap = 0.5,
		item,
		media,
		onAdd,
		type,
		uploadProps,
		...restProps
	} = $props()

	let uploadingMedia    = $state(false)

	function uploadMedia() {
		uploadingMedia    = true
	}
	function closeModal() {
		uploadingMedia    = false
    }

</script>





<Grid class="media-grid w-full {className}" {cols} {gap} {...restProps}>

	{#each media as image}
		{#if item}
			{@render item(image)}
		{:else}
			<Media class="relative aspect-square w-full" media={image} />
		{/if}
	{/each}

	{#if addable}
		{#if add}
			{@render add()}
		{:else}
			<Flex class="aspect-square cursor-pointer w-full">
				<Button style="soft" theme="accent" class="{className} rounded-none w-full"
					type="button"
					icon="Plus" iconSize="xl" iconWeight="light"
					onclick={uploadMedia}
				/>
			</Flex>
		{/if}
	{/if}
	
</Grid>


{#if addable}

	<Modal show={uploadingMedia} onclose={closeModal} maxWidth={aspect === 'aspect-square' ? "lg" : "2xl"}>
		<MediaUploadForm
			{aspect}
			{media}
			{type}
			multiple
			onFinish={(res) => {
				closeModal()
				uploadProps.onFinish?.(res)
			}}
			{...uploadProps}
		/>
	</Modal>

{/if}