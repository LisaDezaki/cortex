<script>

	import { Flex, Inline, Stack } from '@/Components/Core'

	import Back        from '@/Components/UI/Back.svelte'
	import Breadcrumbs from '@/Components/UI/Breadcrumbs.svelte'
	import Button      from '@/Components/UI/Button.svelte'
	import Container   from '@/Components/UI/Container.svelte'
	import Heading     from '@/Components/UI/Heading.svelte'

	let {
		actions,
		back,
		breadcrumbs,
		children,
		class: className,
		color = 'bg-surface',
		eyebrow,
		eyebrowIcon,
		subtitle,
		tabs,
		title,
		...restProps
	} = $props()

</script>



<Stack as="header" align="start" justify="center" gap={0} class="{color} h-16 shrink-0 {className}">

	<Flex align="center" justify="center" class="w-full">

		<!-- Breadcrumbs and page name  -->
		<Stack align="start" gap={0} class="flex-1 w-full">
			<!-- {#if breadcrumbs}
				<Breadcrumbs data={breadcrumbs} />
			{/if} -->
			<Heading is="h1" as="h4"
				class="text-neutral-softest"
				heading={title}
			/>
		</Stack>

		<!-- Tabs -->
		 {#if tabs}
			<Stack align="center" justify="center" gap={1.5} class="flex-0 flex-shrink-0 min-w-48 w-auto">
				<Inline gap={0.5} class="bg-neutral-gradient border border-neutral-softest p-0.5 rounded-full overflow-hidden">
					{#each tabs as tab}
						{#if !tab.hasOwnProperty('if') || tab.if === true}
							<Button
								class="rounded-full w-32"
								size="lg"
								style={tab.active ? 'hard'   : 'plain'}
								theme={tab.active ? 'accent' : 'neutral'}
								{...tab}
							/>
						{/if}
					{/each}
				</Inline>
			</Stack>
		{/if}

		<!-- Actions  -->
		<Stack align="end" justify="center" class="flex-1 w-full">
			{#if actions}
				<Inline gap={3}>
					{#each actions as action}
						{#if !action.hasOwnProperty('if') || action.if === true}
							<Button class="pr-3 rounded-full" size="md" type="button" style={action.style || "hard"} {...action} />
						{/if}
					{/each}
				</Inline>
			{/if}
		</Stack>

	</Flex>

	<Flex align="center" justify="center" class="w-full">
		<Container size="7xl">
			{@render children?.()}
		</Container>
	</Flex>

</Stack>