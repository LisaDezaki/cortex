<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import {
		Flex, Form,
		UploadContext,
		UploadPreview,
		UploadTrigger
	}  from '@/Components/Core'

	import Button	from '@/Components/UI/Button.svelte'
	import Heading	from '@/Components/UI/Heading.svelte'
	import Icon		from '@/Components/UI/Icon.svelte'
	import Modal	from '@/Components/UI/Modal.svelte'

	let {
		aspect,
		class: className,
		disabled = false,
		endpoint = route('upload'),
		icon,
		media,
		mediaType, // project_banner, character_portrait, faction_emblem, location_map, etc
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
				onFinish(req)
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
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
{...restProps}>
	<UploadContext bind:value={$form[requestKey]} preview={media?.url}>
		<button type="button" class="{aspect} {className}" onclick={uploadImage}>
			<UploadTrigger class="flex items-center justify-center h-full w-full">
				<Icon name={icon || 'Image'} size={40} weight="light" class="opacity-50" />
				{#if media}
					<img src={media?.url} alt={media?.type} class="absolute min-h-full min-w-full object-cover text-transparent" />
				{/if}
			</UploadTrigger>
		</button>

		<Modal show={uploadingImage} maxWidth="2xl" onclose={closeModal} class="flex items-start">
			
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
			{/snippet}
		</Modal>
	</UploadContext>
</Form>