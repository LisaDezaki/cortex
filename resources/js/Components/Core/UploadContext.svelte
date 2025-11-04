<script>
	import { getContext, setContext } from "svelte";
	import { writable } from "svelte/store";
	import { page, useForm } from '@inertiajs/svelte';
	import { route } from 'momentum-trail';

	import UploadPreview from './UploadPreview.svelte';
	import UploadTrigger from './UploadTrigger.svelte';

	const uploadedFiles = $page.props.uploadedFiles;

	const { form } = getContext("form");

	let {
		aspect,
		children,
		class: className,
		multiple = false,
		name,
		type = 'upload',
		onTempUpload = () => {}
		// value = $bindable()
	} = $props();

	let uploadForm = useForm({
		files: form && name ? $form[name] : []
	});

	// $effect(() => {
	// 	$form[name] = value
	// })

	// State for uploaded files
	const files    = writable([]);
	let processing = writable(false)

	// let media = $derived(form && name ? $form[name] : [])

	// Method to handle file upload
	function handleFileUpload(event) {
		processing.set(true)
		const input = event.target;
		if (input.files) {
			files.set(Array.from(input.files));
			$uploadForm.files = input.files;
		}

		$uploadForm.post( route('upload.temp'), {
			forceFormData: true,
			onSuccess: (res) => {
				$uploadForm = { ...$uploadForm, files: res.props.flash.success }
				if (form && name) {
					$form[name] = { ...res.props.flash.success.map(f => ({ ...f, type })) }
				}
				processing.set(false)
				onTempUpload?.(res)
			},
			onError: (errors) => {
				// console.log('Upload failed', errors)
			},
			onProgress: (event) => {
				// console.log('Upload progress:', event)
			}
		})
		
		// await axios.post(
		// 	route('upload.temp'),
		// 	$uploadForm,
		// 	{ headers: { 'Content-Type': 'multipart/form-data' } }
		// ).then(response => {
		// 	$uploadForm = { ...$uploadForm,
		// 		files: response.data.files
		// 	}
		// 	if (form && name) {
		// 		$form[name] = { ...response.data.files.map(f => ({ ...f, type })) }
		// 	}
		// 	processing.set(false)
		// });
	}

	function isMultiple() {
		return multiple
	}

	function getFiles() {
		return $uploadForm.files
	}

	// Method to clear files
	function clearFiles() {
		files.set([])
		$uploadForm.files = []
		if (form && name) {
			$form[name] = []
		}
	}

	// Expose state and methods via context
	setContext("file-upload-context", {
		processing,
		files,
		isMultiple,
		handleFileUpload,
		getFiles,
		clearFiles,
		media: $form[name] || null
	});

</script>

<div class="upload-context overflow-hidden {className} {aspect}">
	{#if children}
		{@render children(files, clearFiles)}
	{:else}
		<UploadPreview class="absolute inset-0" />
		<UploadTrigger class="absolute inset-0" />
	{/if}
</div>