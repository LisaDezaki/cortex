<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import {
		Flex, Form,
		UploadContext,
		UploadPreview,
		UploadTrigger
	}  from '@/Components/Core'

	import Button    from '@/Components/UI/Button.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'

	let {
		aspect = 'square',
		class: className,
		disabled = false,
		endpoint = route('upload'),
		icon,
		media,
		method = 'post',
		type, // project_banner, character_portrait, faction_emblem, location_map, etc
		oncancel,
		...restProps
	} = $props()

	const form = useForm({
		files: [],
		type: media?.type,
		value: media?.path
	});

	function submit(e) {
		e.preventDefault();
		$form[method](endpoint, {
			onSuccess: (res) => {
				console.log('Success:', res)
			},
			onFinish: (req) => {
				console.log('Finish:', req)
			}
		})
	}

</script>

<Form
	enctype="multipart/form-data"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<UploadContext bind:value={$form.files} preview={media?.url}>
		<UploadTrigger class="flex items-center justify-center h-full w-full">
			<UploadPreview class="flex items-center justify-center w-full {aspect}">
				<Icon name={icon || 'Image'} size={64} weight="light" class="opacity-50" />
			</UploadPreview>
		</UploadTrigger>
	</UploadContext>
	
	<Flex gap={1.5} justify="end" class="ml-auto p-3">
		<Button style="hard" theme="neutral" class="rounded-full"
			icon="X" onclick={oncancel}
		/>
		<Button style="hard" theme="accent" class="rounded-full"
			icon="Check" onclick={submit}
		/>
	</Flex>
</Form>