<script>
	import clsx 	from 'clsx'
	import Flex 	from '@/Components/Core/Flex.svelte'
	import Button 	from '@/Components/UI/Button.svelte'
	import Icon 	from '@/Components/UI/Icon.svelte'

	let {
		alt,
		class: className,
		imageClass,
		icon,
		iconSize = "xl",
		iconWeight = "light",
		media,
		name,
		onclick,
		url
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		background:  clsx('background relative overflow-hidden', {
			'hover:inner-shadow-lg transition-all': onclick
		}, className),
		img:    clsx('min-h-full min-w-full object-cover', imageClass),
		icon:   clsx('opacity-50 text-neutral-softest'),
		button: clsx('absolute inset-0')
	})

</script>

<!-- /storage/user_a0ba7957/project_a0ba7958/App\Models\Project/2trcL95edcccxeVZxxxt.png -->
<!-- /storage/user_a0ba7957/project_a0ba7958/AppModelsProject/2trcL95edcccxeVZxxxt.png -->

<Flex align="center" justify="center" class={cx.background} style="background-image: url('{url}')">
	<!-- {#if media}
		<img class={cx.img} src={media.url} alt={media.name} />
	{/if} -->
	{#if onclick}
		<Button class={cx.button} onclick={onclick} />
	{/if}
</Flex>