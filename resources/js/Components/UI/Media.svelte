<script>
	import { page, router } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
	import MediaUploadForm from '@/Forms/Media/MediaUploadForm.svelte'
	import { Flex } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Icon from '@/Components/UI/Icon.svelte'
	import Modal from '@/Components/UI/Modal.svelte'

	let {
		aspect,
		class: className,
		media,
		onReplace = () => {},
		replaceable = false,
		type,
		uploadProps,
		...restProps
	} = $props()

	let uploadingMedia    = $state(false)
	let uploadMultiple    = $derived(type == 'gallery')

	function uploadMedia() {
		uploadingMedia    = true
	}
	function closeModal() {
		uploadingMedia    = false
    }

</script>








<Flex align="center" justify="center" class="media {className}" {...restProps}>
	{#if media}
		<img class="min-h-full min-w-full object-cover" src={media.url} alt={media.name} />
	{:else}
		<Icon name="Image" size="xl" weight="light" />
	{/if}

	{#if replaceable}
		<Button
			class="absolute inset-0"
			onclick={uploadMedia}
		/>
	{/if}
</Flex>







{#if replaceable}

	<Modal show={uploadingMedia} onclose={closeModal} maxWidth={aspect === 'aspect-square' ? "lg" : "2xl"}>
		<MediaUploadForm
			{aspect}
			{media}
			{type}
			onFinish={(res) => {
				closeModal()
				uploadProps.onFinish?.(res)
			}}
			{...uploadProps}
		/>
	</Modal>

{/if}