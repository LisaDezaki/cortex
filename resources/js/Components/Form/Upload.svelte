<script>

	import { onMount, onDestroy } from 'svelte';
	import { useForm } from '@inertiajs/svelte';
	import { route } from 'momentum-trail';

	import Button from '@/Components/Button.svelte';
	import Icon from '@/Components/Icon.svelte';

	let {
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



<label for={id} class="input-upload {className}" class:disabled class:focus={hasFocus}>
	<div class="input-upload-preview">

		{#if $uploadForm.path || $uploadForm.blob || preview}
			<img
				src={$uploadForm.path || $uploadForm.blob || preview}
				alt={altText}
				class="preview-image"
			/>
			<button class="image-replace" type="button" onclick={handleReplaceClick} disabled={disabled}>
				<span>Replace</span>
			</button>
		{:else}
			<Icon name="UploadSimple" size="md" />
		{/if}

	</div>
	<div class="input-value {icon ? "pl-icon" : ""}">

		<Icon class="input-icon" name={icon} size="md" />

		{#if value}
			<span class="inline-flex items-center h-8 line-clamp-1 truncate">{value}</span>
			<Button class="input-action ml-auto" icon="X" iconSize="sm" theme="danger" onclick={handleRemoveClick} disabled={disabled} />
		{:else}
			<span class="input-placeholder inline-flex items-center h-8 line-clamp-1 truncate">{placeholder}</span>
		{/if}

	</div>
	<input id={id} class="absolute opacity-0 pointer-events-none"
		bind:this={input}
		accept={accept}
		disabled={disabled}
		onchange={handleFileChange}
		onfocus={checkFocus}
		onblur={checkFocus}
		type="file"
	{...restProps} />
</label>



<style lang="postcss">

	.input-upload {
		@apply relative flex flex-col items-center justify-center gap-1 h-48 min-w-28 p-1;
		@apply border rounded-lg cursor-pointer overflow-hidden;
		&.disabled {
			@apply cursor-not-allowed;
			background-color: var(--bg-disabled);
			border-color: var(--border-disabled);
			color: var(--text-disabled);
		}
		&:hover {		
			.image-replace {
				opacity: 1;
			}
		}

		.input-upload-preview {
			@apply relative flex items-center justify-center h-full min-w-full max-w-none max-h-none object-cover overflow-hidden rounded;
			background-color: var(--bg-neutral-softest);
		}
		.image-replace {
			@apply absolute inset-0 h-full rounded w-full text-white;
			@apply backdrop-blur-sm transition-all;
			opacity: 0;
		}
	}

</style>