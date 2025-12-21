<script>
	import { Link } from '@inertiajs/svelte'
	import { Flex, Stack } from '@/Components/Core'
	import Icon from '@/Components/UI/Icon.svelte'

	let {
		buttonLabel = "Create",
		buttonHref,
		buttonClick,
		class: className,
		containerClass,
		icon,
		text = "There are no results here",
	} = $props()

</script>



<Stack align="center" justify="center" gap={3} class="p-6 rounded {className}">
	{#if icon}
		<Flex justify="center">
			<Icon name={icon} />
		</Flex>
	{/if}
	<p class="font-style-placeholder">{text}</p>
	{#if buttonClick}
		<button class="px-2 py-1 rounded-md text-accent hover:underline" onclick={buttonClick}>{buttonLabel}</button>
	{:else if buttonHref}
		<Link class="px-2 py-1 rounded-md text-accent hover:underline" href={buttonHref}>{buttonLabel}</Link>
	{/if}
</Stack>