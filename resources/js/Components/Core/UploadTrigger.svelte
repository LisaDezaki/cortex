<script>
  import { getContext } from "svelte";
  import Button from '@/Components/UI/Button.svelte';

  const { files, handleFileUpload, multiple } = getContext("file-upload-context");

  let {
	children,
	class: className,
	icon,
	label,
} = $props();

  let fileInput;

  function triggerFileInput() {
    fileInput.click();
  }
</script>





<label class="upload-trigger cursor-pointer z-10 {className}">
	
	<!-- Hidden file input -->
	<input
		type="file"
		bind:this={fileInput}
		onchange={handleFileUpload}
		style="display: none;"
		multiple={multiple}
	/>
	
	<!-- Custom trigger (can be styled however needed) -->
	{#if children}
		{@render children()}
	{:else if $files == {} || $files.length === 0}
		<Button style="soft" theme="accent" class="{className} z-10"
			icon={icon || "UploadSimple"} label={label || "Upload"}
			onclick={triggerFileInput}
		/>
	{:else}
		<Button style="soft" theme="white" class="backdrop-blur-sm z-10"
			icon={icon || "UploadSimple"} label={label || "Replace"}
			onclick={triggerFileInput}
		/>
	{/if}

</label>
