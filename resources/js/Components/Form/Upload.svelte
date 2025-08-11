<script>

	import { onMount, onDestroy } from 'svelte';
	import { useForm } from '@inertiajs/svelte';
	import { route } from 'momentum-trail';

	import UploadContext from '@/Components/Util/UploadContext.svelte'
	import UploadPreview from '@/Components/Util/UploadPreview.svelte'
	import UploadTrigger from '@/Components/Util/UploadTrigger.svelte'

	import Button from '@/Components/Button.svelte';
	import Icon from '@/Components/Icon.svelte';

	let {
		aspect = "square",
		class: className,
		altText = '',
		accept = 'image/*',
		handleUpload,
		icon,
		id,
		maxSizeMB = null,
		placeholder,
		disabled = false,
		preview = null,
		value = $bindable(),
		...restProps
	} = $props();

	let uploadForm = useForm({
		value: value
	});

	let input
	let hasFocus = $state(false)

	function checkFocus() {
		hasFocus = document.activeElement === input;
	}

	function handleReplaceClick() {
		input?.click();
	}

	function handleRemoveClick() {
		if (input) {
			input.value = null;
			value = null;
			preview = null;
			$uploadForm.file = null;
			$uploadForm.blob = null;
		}
	}

	async function handleFileChange(e) {
		const selectedFile = e.target.files?.[0];
		if (!selectedFile) return;
		$uploadForm = { ...$uploadForm,
			file: selectedFile,
			files: e.target.files,
			blob: URL.createObjectURL(selectedFile),
		}
		await axios.post(
			route('upload.temp'),
			$uploadForm,
			{ headers: { 'Content-Type': 'multipart/form-data' } }
		).then(response => {
			$uploadForm = { ...$uploadForm,
				...response.data.file
			}
			value = response.data.file.temp_path;
			if (input) input.value = '';
		});
	}

	onMount(() => {
        if (restProps.autofocus && input) {
			hasFocus = true
            input.focus()
        }
    })

	onDestroy(() => {
		if ($uploadForm.blob) {
			URL.revokeObjectURL($uploadForm.blob);
		}
	});

</script>

<UploadContext bind:value={value}>
	<UploadTrigger label="Upload Portrait" class="input flex-col p-2 {className}">

		<UploadPreview class="aspect-{aspect}" />

		<div class="flex items-center gap-2 p-1 w-full">
			<Icon name={icon || "File"} size="md" />
			{#if value}
				<span class="inline-flex items-center h-8 line-clamp-1 truncate">{value}</span>
				<Button class="input-action ml-auto" icon="X" iconSize="sm" theme="danger" onclick={handleRemoveClick} disabled={disabled} />
			{:else}
				<span class="input-placeholder inline-flex items-center h-8 line-clamp-1 truncate">{placeholder || "Upload a portrait..."}</span>
			{/if}
		</div>

	</UploadTrigger>
</UploadContext>