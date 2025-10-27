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
		message = "There are no results here",
	} = $props()

</script>



<Stack class={containerClass}>
	<Stack align="center" gap={3} class="border-2 border-dashed border-neutral-softest py-6 {className}">
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
</Stack>