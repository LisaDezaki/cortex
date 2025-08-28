<script>
  import { getContext } from "svelte";
  import Button from '@/Components/UI/Button.svelte';

  const { files, handleFileUpload, isMultiple, getValue } = getContext("file-upload-context");

  let {
	accept = "image/*",
	children,
	class: className,
	icon,
	label,
	...restProps
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
		multiple={isMultiple()}
	/>

	<!-- Custom trigger (can be styled however needed) -->
	{#if children}
		{@render children()}
	{:else if $files.length > 0 || getValue}
		<Button style="plain" theme="neutral"
			onclick={triggerFileInput}
		{...restProps} />
	{:else}
		<Button style="plain" theme="neutral"
			onclick={triggerFileInput}
		{...restProps} />
	{/if}

</label>