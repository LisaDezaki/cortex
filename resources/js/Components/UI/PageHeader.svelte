<script>

	import { Flex, Inline, Stack } from '@/Components/Core'
	import Back			from '@/Components/UI/Back.svelte'
	import Button		from '@/Components/UI/Button.svelte'
	import Container	from '@/Components/UI/Container.svelte'
	import Heading		from '@/Components/UI/Heading.svelte'
    import clsx from 'clsx'

	let {
		actions,
		back,
		backLabel,
		children,
		class: className,
		color = 'bg-surface',
		size,
		tabs,
		title
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		header: clsx({
			'page-header sticky top-0 flex-none shadow-sm w-full z-10': true,
		}, color, className),
		tabs: clsx('bg-neutral-gradient border border-neutral-softest flex-none w-auto gap-0.5 p-0.5 rounded-full overflow-hidden')
	})

</script>



<Stack as="header" class={cx.header} align="center" justify="center">

	<Container size={size}>
		<Flex align="center" justify="center" class="w-full">

			
			<!-- Breadcrumbs and page name  -->
			<Stack align="start" gap={0} class="flex-1 w-full">
				{#if back && backLabel && typeof back === 'string'}
					<Back href={back} text={backLabel} />
				{/if}
				{#if back && backLabel && typeof back === 'function'}
					<Back onclick={back} text={backLabel} />
				{/if}
				<Heading is="h1" as="h4" class="text-neutral-softest">{title}</Heading>
			</Stack>
	
			<!-- Tabs -->
			 {#if tabs}
				<Inline gap={0.5} class={cx.tabs}>
					{#each tabs as tab}
						{#if !tab.hasOwnProperty('if') || tab.if === true}
							<Button
								size="md"
								class="min-w-32 rounded-full {tab.active ? 'bg-emerald-600 text-white' : 'hover:text-accent'}"
								style="plain"
								{...tab}
							/>
						{/if}
					{/each}
				</Inline>
			{/if}

			<!-- Actions  -->
			<Stack align="end" justify="center" class="flex-1 w-full">
				{#if actions}
					<Inline gap={3}>
						{#each actions as action}
							{#if !action.hasOwnProperty('if') || action.if === true}
								<Button size="md" class="pr-3 rounded-full" type="button" style={action.style || "soft"} {...action} />
							{/if}
						{/each}
					</Inline>
				{/if}
			</Stack>
	
		</Flex>
		{@render children?.()}

	</Container>
</Stack>