<script>
	import { Flex } from '@/Components/Core'
	import Button 	from '@/Components/UI/Button.svelte'
	import Icon 	from '@/Components/UI/Icon.svelte'

	let {
		class: className,
		imageClass,
		media,
		onclick,
	} = $props()

</script>





<Flex align="center" justify="center" class="media {className} overflow-hidden">
	{#if media}
		<img class="min-h-full min-w-full object-cover {imageClass}" src={media.url} alt={media.name} />
	{:else}
		<Icon name="Image" size="xl" weight="light" />
	{/if}
	{#if onclick}
		<Button
			class="absolute inset-0"
			onclick={onclick}
		/>
	{/if}
</Flex>