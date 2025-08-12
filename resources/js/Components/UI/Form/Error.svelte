<script>
	let {
		message,
		...restProps
	} = $props()
</script>

{#if message}
	<p class="form-field-error mt-1" {...restProps}>
		{message}
	</p>
{/if}

<style lang="postcss">
	.form-field-error {
		@apply text-sm;
		color: var(--text-danger);
	}
</style>