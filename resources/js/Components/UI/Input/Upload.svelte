<script>

	import { onMount, onDestroy } from 'svelte';
	import { useForm } from '@inertiajs/svelte';
	import { route } from 'momentum-trail';

	import { Flex, UploadContext, UploadPreview, UploadTrigger } from '@/Components/Core';

	import Button        from '@/Components/UI/Button.svelte';
	import Icon          from '@/Components/UI/Icon.svelte';

	let {
		aspect = "aspect-square",
		class: className,
		altText = '',
		accept = 'image/*',
		handleUpload,
		icon = "File",
		id,
		maxSizeMB = null,
		placeholder = "Upload a file...",
		disabled = false,
		preview = null,
		size = "md",
		value = $bindable(),
		...restProps
	} = $props();

	// let uploadForm = useForm({
	// 	value: value
	// });

	// let input
	// let hasFocus = $state(false)

	// function checkFocus() {
	// 	hasFocus = document.activeElement === input;
	// }

	// function handleReplaceClick() {
	// 	input?.click();
	// }

	// function handleRemoveClick() {
	// 	if (input) {
	// 		input.value = null;
	// 		value = null;
	// 		preview = null;
	// 		$uploadForm.file = null;
	// 		$uploadForm.blob = null;
	// 	}
	// }

	// async function handleFileChange(e) {
	// 	const selectedFile = e.target.files?.[0];
	// 	if (!selectedFile) return;
	// 	$uploadForm = { ...$uploadForm,
	// 		file: selectedFile,
	// 		files: e.target.files,
	// 		blob: URL.createObjectURL(selectedFile),
	// 	}
	// 	await axios.post(
	// 		route('upload.temp'),
	// 		$uploadForm,
	// 		{ headers: { 'Content-Type': 'multipart/form-data' } }
	// 	).then(response => {
	// 		$uploadForm = { ...$uploadForm,
	// 			...response.data.file
	// 		}
	// 		value = response.data.file.temp_path;
	// 		if (input) input.value = '';
	// 	});
	// }

	// onMount(() => {
        // if (restProps.autofocus && input) {
		// 	hasFocus = true
        //     input.focus()
        // }
    // })

	// onDestroy(() => {
		// if ($uploadForm.blob) {
		// 	URL.revokeObjectURL($uploadForm.blob);
		// }
	// });

</script>

<UploadContext bind:value={value}>
	<UploadTrigger label="Upload File" class="input flex-col p-1.5 {className}">

		<UploadPreview class="{aspect} rounded-md overflow-hidden" />

		<Flex align="center" gap={2} class="p-1 w-full">
			{#if icon}
				<Icon name={icon} size={size} />
			{/if}
			{#if value}
				<span class="inline-flex items-center h-8 line-clamp-1 truncate">{value}</span>
			{:else}
				<span class="input-placeholder inline-flex items-center h-8 line-clamp-1 truncate">{placeholder}</span>
			{/if}
		</Flex>

	</UploadTrigger>
</UploadContext>