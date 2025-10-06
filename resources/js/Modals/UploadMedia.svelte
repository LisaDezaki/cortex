<script>
	import { useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import { Grid, UploadContext, UploadPreview, UploadTrigger } from '@/Components/Core'
	import ModalForm from '@/Components/UI/ModalForm.svelte'

	let {
		aspect,
		endpoint = route('upload'),
		media,
		method = 'post',
		multiple = false,
		type = 'gallery',
		...restProps
	} = $props()

	const mediaUploadForm = useForm({ media })

</script>



<ModalForm title="Upload Media" size={aspect == "aspect-square" ? "md" : "xl"}
	endpoint={endpoint}
	form={mediaUploadForm}
	method={method}
	submitProps={{
		label: 'Upload'
	}}
{...restProps}>
	<UploadContext name="media" {type} {multiple} {aspect}>

		{#if !multiple}

			<UploadPreview index={0} class="relative flex items-center justify-center overflow-hidden w-full {aspect}">
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
</ModalForm>