<script>
	import { Link } from '@inertiajs/svelte'
	import { Flex, Stack } from '@/Components/Core'
	import Icon from '@/Components/UI/Icon.svelte'

	let {
		icon,
		message = "There are no results here",
		buttonLabel = "Create",
		buttonHref,
		buttonClick
	} = $props()

</script>

<Stack align="center" gap={3} class="border-2 border-dashed border-neutral-softest py-6 w-full">
	{#if icon}
		<Flex justify="center">
			<Icon name={icon} />
		</Flex>
	{/if}
	<p class="font-style-placeholder">{message}</p>
	{#if buttonClick}
		<button class="px-2 py-1 rounded-md text-accent hover:underline" onclick={buttonClick}>{buttonLabel}</button>
	{:else if buttonHref}
		<Link class="px-2 py-1 rounded-md text-accent hover:underline" href={buttonHref}>{buttonLabel}</Link>
	{/if}
</Stack>