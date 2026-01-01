<script>
	import { Link } from '@inertiajs/svelte'

	//	Layout & Components

	import Flex		from '@/Components/Core/Flex.svelte'
	import Inline	from '@/Components/Core/Inline.svelte'
	import Stack	from '@/Components/Core/Stack.svelte'
	import Button	from '@/Components/UI/Button.svelte'


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



<Flex align="baseline" justify="start" gap={2} class={cx.item}>
	<span class={cx.label}>{label}</span>
	{#if children}
		<span>{@render children()}</span>
	{:else if value}
		<!-- <span class="break-all"> -->
			{#if typeof value === 'object' && Array.isArray(value)}
				<Stack>
					{#each value as item, i}
						<Inline>
							<span class="line-clamp-1">
								{#if item.href}
									<Link href={item.href}>{item.value}</Link>
								{:else}
									{item.value}
								{/if}
								{#if item.appendix}
									<span class="text-neutral-soft">({item.appendix})</span>{value.length-1 !== i ? ', ' : ''}
								{:else}
									{value.length-1 !== i ? ', ' : ''}
								{/if}
							</span>
						</Inline>
					{/each}
				</Stack>
			{:else}
				<span>{value}</span>
			{/if}
			
		<!-- </span> -->
	{:else}
		<span class={cx.empty}>None</span>
	{/if}
	{#if onclick}
		<Button class={cx.edit}
			style="plain" theme="accent" size="XS"
			icon="PencilSimple"
			onclick={onclick}
		/>
	{/if}
</Flex>