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
		eyebrow,
		eyebrowIcon,
		subtitle,
		tabs,
		title,
		...restProps
	} = $props()

</script>





<Stack as="header" align="start" gap={0} class="bg-surface border-b p-2 w-full">

	<Flex justify="center" class="w-full">

		<!-- Breadcrumbs and page name  -->
		<Stack align="start" gap={0} class="flex-1 pb-2 w-full">
			{#if breadcrumbs}
				<Breadcrumbs data={breadcrumbs} />
			{/if}
			<Inline gap={3} class="px-3 w-full">
				<Heading is="h1" as="h4"
					heading={title}
				/>
			</Inline>
		</Stack>

		<!-- Tabs -->
		 {#if tabs}
			<Stack align="center" justify="center" gap={1.5} class="flex-0 flex-shrink-0 min-w-48 w-auto">
				<Inline gap={0.5} class="bg-neutral-softer p-0.5 rounded-lg overflow-hidden">
					{#each tabs as tab}
						<Button style={tab.active ? 'hard' : 'plain'} theme={tab.active ? 'accent' : 'neutral'}
							{...tab}
						/>
					{/each}
				</Inline>
			</Stack>
		{/if}

		<!-- Actions  -->
		<Stack align="end" justify="center" class="flex-1 w-full">
			{#if actions}
				<Inline gap={3} class="px-3 py-1.5">
					{#each actions as action}
						<Button type="button" style={action.style || "soft"} {...action} class="h-10 w-10 rounded-full" />
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