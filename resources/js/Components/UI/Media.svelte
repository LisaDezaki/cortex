<script>
	import { Flex } from '@/Components/Core'
	import Button 	from '@/Components/UI/Button.svelte'
	import Icon 	from '@/Components/UI/Icon.svelte'

	let {
		class: className,
		imageClass,
		icon,
		iconSize = "xl",
		iconWeight = "light",
		media,
		onclick,
	} = $props()

</script>



<Flex align="center" justify="center" class="media overflow-hidden {className}">
	{#if media}
		<img class="min-h-full min-w-full object-cover {imageClass}" src={media.url} alt={media.name} />
	{:else if icon}
		<Icon class="opacity-50 text-neutral-softest" name={icon} size={iconSize} weight={iconWeight} />
	{/if}
	{#if onclick}
		<Button
			class="absolute inset-0"
			onclick={onclick}
		/>
	{/if}
</Flex>