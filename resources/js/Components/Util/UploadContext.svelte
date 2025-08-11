<script>
	import { setContext } from "svelte";
	import { writable } from "svelte/store";

	// State for uploaded files
	const files = writable([]);

	let { children, class: className } = $props();

	// Method to handle file upload
	function handleFileUpload(event) {
		const input = event.target;
		if (input.files) {
			files.set(Array.from(input.files));
		}
	}

	// Method to clear files
	function clearFiles() {
		files.set([]);
	}

	// Expose state and methods via context
	setContext("file-upload-context", {
		files,
		handleFileUpload,
		clearFiles,
	});

</script>

<!-- Slot allows flexible placement of children -->
<div class="upload-context {className}">
	 {@render children(files, clearFiles)}
</div>