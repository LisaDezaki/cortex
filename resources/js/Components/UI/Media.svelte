<script>
	import { modalActions } from '@/stores/modalStore';
	
	import { Flex } from '@/Components/Core'
	import Button 	from '@/Components/UI/Button.svelte'
	import Icon 	from '@/Components/UI/Icon.svelte'

	let {
		aspect = 'aspect-square',
		class: className,
		media,
		replaceable = false,
		...restProps
	} = $props()

</script>





<Flex align="center" justify="center" class="media {aspect} {className}">
	{#if media}
		<img class="min-h-full min-w-full object-cover" src={media.url} alt={media.name} />
	{:else}
		<Icon name="Image" size="xl" weight="light" />
	{/if}
	{#if replaceable}
		<Button
			class="absolute inset-0"
			onclick={() => modalActions.open('uploadMedia', { aspect, media, ...restProps })}
		/>
	{/if}
</Flex>