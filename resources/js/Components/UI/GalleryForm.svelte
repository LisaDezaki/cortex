<script>
	import { useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import {
		Form,
		UploadContext,
		UploadPreview,
		UploadTrigger
	 } from '@/Components/Core'

	import Button  from '@/Components/UI/Button.svelte'
	import Heading from '@/Components/UI/Heading.svelte'
	import Icon    from '@/Components/UI/Icon.svelte'
	// import MediaGrid from '@/Components/UI/MediaGrid.svelte'
	import Modal   from '@/Components/UI/Modal.svelte'
    import Upload from '../../Forms/Media/Upload.svelte'

	let {
		class: className,
		cols = 6,
		endpoint = route('upload'),
		media,
		mediaType,
		method = 'post',
		onSuccess,
		onFinish,
		requestKey,
		...restProps
	} = $props()

	const form = useForm({
		[requestKey]: null
	});

	let uploadingImage = $state(false)

	function submit(e) {
		e.preventDefault();
		$form[ method ]( endpoint, {
			onSuccess,
			onFinish: (req) => {
				closeModal()
				onFinish?.(req)
			}
		})
	}

	function uploadImage() {
		uploadingImage = true
	}

	function closeModal() {
		uploadingImage = false
	}

</script>




<Form
	enctype="multipart/form-data"
	recentlySuccessful={$form.recentlySuccessful}
{...restProps}>

	<UploadContext bind:value={$form[requestKey]} preview={media?.url} multiple>

		<!-- <MediaGrid addable cols={cols} media={media} onAdd={uploadImage} /> -->

		<Modal show={uploadingImage} maxWidth="2xl" onclose={closeModal} class="flex items-start">

			<Upload
				endpoint={endpoint}
				method={method}
				requestKey={requestKey}
			/>
			
			<!-- <UploadTrigger />
			<UploadPreview class="h-full flex items-center justify-center" />
			
			{#snippet footer()}
				<Heading heading="Upload Image" />

				<Flex gap={1.5} class="ml-auto">
					<Button style="hard" theme="neutral" class="rounded-full"
						icon="X" onclick={closeModal}
					/>
					<Button style="hard" theme="accent" class="rounded-full"
						icon="Check" onclick={submit}
					/>
				</Flex>
			{/snippet} -->
		</Modal>
	</UploadContext>
</Form>