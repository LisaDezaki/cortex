<script>

	import { Flex, Inline, Stack } from '@/Components/Core'
	import Button      from '@/Components/UI/Button.svelte'
	import Heading     from '@/Components/UI/Heading.svelte'
    import clsx from 'clsx'

	let {
		actions,
		children,
		class: className,
		color = 'bg-surface',
		tabs,
		title
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		header: clsx({
			'page-header sticky top-0 min-h-14 shrink-0 w-full z-10': true,
		}, color, className),
		tabs: clsx('bg-neutral-gradient border border-neutral-softest flex-0 shrink-0 min-w-48 w-auto px-0.5 rounded-full overflow-hidden')
	})

</script>



<Stack as="header" class={cx.header} align="start" justify="center" gap={1.5}>

	<Flex align="center" justify="center" class="w-full">

		<!-- Breadcrumbs and page name  -->
		<Stack align="start" gap={0} class="flex-1 w-full">
			<Heading is="h1" as="h4" class="text-neutral-softest">{title}</Heading>
		</Stack>

		<!-- Tabs -->
		 {#if tabs}
			<Inline gap={0.5} class={cx.tabs}>
				{#each tabs as tab}
					{#if !tab.hasOwnProperty('if') || tab.if === true}
						<Button
							class="rounded-full w-32 {tab.active ? '' : 'hover:text-accent'}"
							style={tab.active ? 'hard'   : 'plain'}
							theme={tab.active ? 'accent' : 'neutral'}
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
							<Button class="pr-3 rounded-full" type="button" style={action.style || "hard"} {...action} />
						{/if}
					{/each}
				</Inline>
			{/if}
		</Stack>

	</Flex>

	{@render children?.()}

</Stack>