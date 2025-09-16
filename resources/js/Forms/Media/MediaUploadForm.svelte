<script>
	import { useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import {
		Box, Flex, Form, Grid,
		UploadContext,
		UploadPreview,
		UploadTrigger
	 } from '@/Components/Core'

	import Button  from '@/Components/UI/Button.svelte'
	import Icon    from '@/Components/UI/Icon.svelte'
	import Heading from '@/Components/UI/Heading.svelte'

	let {
		aspect,
		class: className,
		endpoint = route('upload'),
		media,
		method = 'post',
		multiple = false,
		oncancel,
		type = 'gallery',
		...restProps
	} = $props()

	const mediaUploadForm = useForm({ media })

</script>





<Form
	enctype="multipart/form-data"
	endpoint={endpoint}
	form={mediaUploadForm}
	method={method}
{...restProps}>

	<UploadContext name="media" {type} {multiple}>

		{#if !multiple}

			<UploadPreview index={0} class="relative flex items-center justify-center overflow-hidden rounded-t-lg w-full {aspect}">
				<UploadTrigger class="absolute top-0 left-0 h-full w-full" />
			</UploadPreview>

		{:else if multiple}

			<Grid cols={4}>
				{#each $mediaUploadForm.media?.filter(m => m.type == media.type) as media, i}
					<UploadPreview index={i} />
				{/each}
				<UploadTrigger class="aspect-square bg-accent-softest border border-accent-softest text-accent w-full"
					icon="Plus"
				/>
			</Grid>

		{/if}
	</UploadContext>

	<Flex class="border-t p-3">
		<Heading heading="Upload Image{multiple ? 's' : ''}" />
		<Flex gap={1.5} class="ml-auto">
			<Button type="button"
				style="hard" theme="neutral"
				class="rounded-full"
				icon="X" onclick={oncancel}
			/>
			<Button type="submit"
				style="hard" theme="accent"
				class="rounded-full"
				icon="Check"
			/>
		</Flex>
	</Flex>
	
</Form>