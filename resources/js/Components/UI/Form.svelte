<script>

	import { setContext, getContext } from 'svelte';
	import { useForm } from '@inertiajs/svelte';
  
	const FORM_CONTEXT = Symbol('form_context'); // Context keys

	let {
		children,
		class: className,
		endpoint = '/',
		method = 'post',
		submitText = 'Save',
		disabled = false,
		initialData = {},
		...restProps
	} = $props()
  
	// Create form instance
	const formInstance = useForm(initialData);
  
	// Use effect to handle initialData changes
	$effect(() => {
		if (Object.keys(initialData).length > 0) {
			formInstance.setData(initialData);
		}
	})

	// Provide form context to child components
	setContext(FORM_CONTEXT, {
		form: formInstance,
		endpoint,
		method
	})
  
	function handleSubmit(e) {
		e.preventDefault()
		formInstance.submit(method, endpoint, {
		onSuccess: () => {
			if (method === 'post') {
				formInstance.reset()
			}
		}
		});
	}

</script>




<form class={className} onsubmit={handleSubmit} {...restProps}>

	<!-- <slot {formInstance} /> -->

	<Flex justify="end">
		<Button style="soft" theme="neutral"
			icon="X"
		/>
		<Button style="soft" theme="accent"
			icon="Check"
		/>
	</Flex>

	{@render children?.(formInstance)}
	
	<button 
		type="submit" 
		disabled={disabled || formInstance.processing}
		class="btn btn-primary"
	>
		{submitText}
		{#if formInstance.processing}
		<span class="loading-spinner">...</span>
		{/if}
	</button>
</form>