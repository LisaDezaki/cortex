<script>
	import Flex		from '@/Components/Core/Flex.svelte'
	import Inline	from '@/Components/Core/Inline.svelte'
	import Stack	from '@/Components/Core/Stack.svelte'
	import Button	from '@/Components/UI/Button.svelte'
	import Heading	from '@/Components/UI/Heading.svelte'
	import clsx from 'clsx'

	let {
		actions,
		class: className,
		is = 'h1',
		as = 'h3',
		title,
		subtitle
	} = $props()

	let cx = {
		heading: 	clsx('', className),
		title:	 	clsx('text-neutral'),
		subtitle:	clsx('text-lg text-neutral-softer')
	}
</script>

<Flex class={cx.heading} align="center" justify="between" gap={6}>
	<Stack>
		<Heading {is} {as} class={cx.title}>{title}</Heading>
		<p class={cx.subtitle}>{subtitle}</p>
	</Stack>

	{#if actions?.length > 0}
		<Inline>
			{#each actions as action}
				<Button class="rounded-full" size="xl" style="soft" theme="accent" {...action} />
			{/each}
		</Inline>
	{/if}
</Flex>
