<script>

	import Button from '@/Components/Button.svelte';
	import Icon from '@/Components/Icon.svelte';

	let {
		class: className,
		layout = $bindable(),
		options,
        ...restProps
    } = $props()

</script>





<div class="input layout-switcher {className}" {...restProps}>
	{#each options as option}
		<button
			class="layout-item"
			class:active={layout === option.value}
			onclick={() => layout = option.value}
		>
			<Icon name={option.icon} size={24} weight="light" />
		</button>
	{/each}
</div>





<style lang="postcss">

	.layout-switcher {
		@apply flex items-center;

		.layout-item {
			@apply inline-flex items-center justify-center p-1;
			&.active {
				color: var(--text-accent);
			}
		}
	}

</style>