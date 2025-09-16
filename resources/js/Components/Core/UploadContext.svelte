<script>
	import { getContext, setContext } from "svelte";
	import { writable } from "svelte/store";
	import { useForm } from '@inertiajs/svelte';
	import { route } from 'momentum-trail';

	const { form } = getContext("form");

	let {
		children,
		class: className,
		multiple = false,
		name,
		type = 'upload',
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
	async function handleFileUpload(event) {
		processing.set(true)

		const input = event.target;
		if (input.files) {
			files.set(Array.from(input.files));
			$uploadForm.files = input.files;
		}

		await axios.post(
			route('upload.temp'),
			$uploadForm,
			{ headers: { 'Content-Type': 'multipart/form-data' } }
		).then(response => {
			console.log(response.data.files);
			// let responseData = multiple ? response.data.files : response.data.files?.[0]
			// value = responseData
			$uploadForm = { ...$uploadForm,
				files: response.data.files
			}
			if (form && name) {
				$form[name] = { ...response.data.files.map(f => ({ ...f, type })) }
			}
			processing.set(false)
		});
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

<div class="upload-context overflow-hidden {className}">
	{@render children(files, clearFiles)}
</div>

<!-- <pre>{JSON.stringify(processing,null,3)}</pre> -->