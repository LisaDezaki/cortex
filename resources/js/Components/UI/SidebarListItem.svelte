<script>
	import { Link } from '@inertiajs/svelte'

	//	Layout & Components

	import Flex					from '@/Components/Core/Flex.svelte'
	import Button				from '@/Components/UI/Button.svelte'


	//	Page & Component props

	let {
		children,
		label,
		onclick,
		value
	} = $props()


	//	Tailwind class management

	const cx = {
		item:   "text-sm font-light group border-t px-1 py-2 text-neutral",
		label:  "text-xs shrink-0 text-neutral-soft min-w-20 pt-0.5",
		value:  "text-neutral",
		empty:  "text-neutral-softest italic",
		edit: 	"opacity-0 group-hover:opacity-100 h-5 w-5 ml-auto place-self-start rounded-full",
	}

</script>

<!-- <pre>{JSON.stringify(value,null,3)}</pre> -->

<Flex align="baseline" justify="start" gap={2} class={cx.item}>
	<span class={cx.label}>{label}</span>
	{#if children}
		<span>{@render children()}</span>
	{:else if value}
		<span>
			{#if typeof value === 'object' && Array.isArray(value)}
				{#each value as item, i}
					{#if item.href}
						<Link href={item.href}>{item.value}</Link>{value.length-1 !== i ? ', ' : ''}
					{:else}
						{item.value}{value.length-1 !== i ? ', ' : ''}
					{/if}
				{/each}
			{:else}
				{value}
			{/if}
		</span>
	{:else}
		<span class={cx.empty}>None</span>
	{/if}
	{#if onclick}
		<Button class={cx.edit}
			style="plain" theme="accent" size="sm"
			icon="PencilSimple" iconSize="xs"
			onclick={onclick}
		/>
	{/if}
</Flex>