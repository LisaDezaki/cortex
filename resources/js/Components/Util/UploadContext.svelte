<script>
	import { setContext } from "svelte";
	import { writable } from "svelte/store";
	import { useForm } from '@inertiajs/svelte';
	import { route } from 'momentum-trail';

	// State for uploaded files
	const files = writable([]);

	let {
		children,
		class: className,
		multiple = false,
		value = $bindable(),
	} = $props();

	let uploadForm = useForm({
		files: [],
		value: value
	});

	// Method to handle file upload
	async function handleFileUpload(event) {
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
			console.log(response.data);
			$uploadForm = { ...$uploadForm,
				...response.data.files.map(f => f.temp_path)
			}
			if (multiple) {
				value = response.data.files?.map(f => f.temp_path)
			} else {
				value = response.data.files?.[0]?.temp_path
			}
		});
	}

	// Method to clear files
	function clearFiles() {
		files.set([]);
	}

	// Expose state and methods via context
	setContext("file-upload-context", {
		files,
		multiple,
		handleFileUpload,
		clearFiles,
	});

</script>

<!-- Slot allows flexible placement of children -->
<div class="upload-context {className}">
	 {@render children(files, clearFiles)}
</div>