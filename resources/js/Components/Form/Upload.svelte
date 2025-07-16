<!-- SCRIPT -->

<script>

	//	Import onDestroy from Svelte to handle component lifecycle
	import { onDestroy } from 'svelte';

	//  Import useForm to handle form submission
	import { useForm } from '@inertiajs/svelte';

	//  Import route from Momentum Trail to handle routing
	import { route } from 'momentum-trail';

	//  Import Components to use within this component
	import Button from '@/Components/Button.svelte';
	import Icon from '@/Components/Icon.svelte';

	//	Define the component properties using $props
	let {
		class: className,
		altText = '',
		accept = 'image/*',
		handleUpload,
		id,
		maxSizeMB = null,
		disabled = false,
		previewPath = null,
		value = $bindable(),
		...attrs
	} = $props();

	//	Declare a variable to hold the input element reference
	let input = null;

	//	Use $state to create a reactive state for the preview URL
	let previewUrl = $state(previewPath || null);

	//	Create a form instance to handle file uploads
	const uploadForm = useForm({
		file: null
	});

	//	Handle the file change event
	async function handleFileChange(e) {
		const selectedFile = e.target.files?.[0];
		if (!selectedFile) return;
		$uploadForm.file = selectedFile;
		previewUrl = URL.createObjectURL(selectedFile);
		await axios.post(
			route('image.upload'),
			$uploadForm,
			{ headers: { 'Content-Type': 'multipart/form-data' } }
		).then(response => {
			// console.log(response);
			value = response.data.filePath;
			previewUrl = response.data.fileUrl;
			// console.log(value);
		});
	}

	function handleReplaceClick() {
		input?.click();
	}

	function handleRemoveClick() {
		previewUrl = null;
		if (input) {
			input.value = null;
			value = null;
		}
	}

	onDestroy(() => {
		if (previewUrl) {
			URL.revokeObjectURL(previewUrl);
		}
	});

</script>



<!-- STRUCTURE -->

<label for={id} class="form-upload {className}" class:disabled>

	<!-- Preview or Icon -->

	{#if previewUrl}

			<img
				src={previewUrl}
				alt={altText}
				class="preview-image"
			/>

			<!-- <div class="preview-blur backdrop-blur-sm {value ? 'w-0' : 'w-full'}"></div> -->
			
			<div class="image-controls">
				<button class="image-replace" type="button" onclick={handleReplaceClick} disabled={disabled}>
					<span>Replace</span>
				</button>
				<Button danger class="image-remove" icon="Trash" onclick={handleRemoveClick} disabled={disabled}>
					<span class="sr-only">Remove</span>
				</Button>
			</div>

	{:else}
		<Icon name="UploadSimple" size={24} />
	{/if}

	<!-- Hidden input -->

	<input
		{...attrs}
		type="file"
		id={id}
		accept={accept}
		class="invisible hidden"
		onchange={handleFileChange}
		bind:this={input}
		disabled={disabled}
	/>

</label>



<!-- STYLE -->

<style lang="postcss">

	.form-upload {
		@apply relative flex flex-col items-center justify-center min-h-20;
		@apply border rounded-lg cursor-pointer overflow-hidden;
		background-color: var(--bg-input);
		border-color: var(--border-input);
		color: var(--text-input);
		&.disabled {
			@apply cursor-not-allowed;
			background-color: var(--bg-disabled);
			border-color: var(--border-disabled);
			color: var(--text-disabled);
		}
		&:hover {
			background-color: var(--bg-input-hover);
			border-color: var(--border-input-hover);
			color: var(--text-input-hover);
			
			.image-controls {
				opacity: 1;
			}
		}

		.preview-image {
			@apply block h-auto object-cover rounded w-full;
		}

		.image-controls {
			@apply absolute top-0 left-0 h-full w-full;
			@apply backdrop-blur-sm transition-all;
			opacity: 0;

			.image-replace {
				@apply absolute top-0 left-0 h-full w-full text-white;
			}

			:global(.image-remove) {
				@apply absolute top-1 right-1 h-8 w-8 z-10;
			}
		}
	}

</style>