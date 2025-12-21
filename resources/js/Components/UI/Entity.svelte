<script>
	import { Link } from '@inertiajs/svelte'
	import Flex   from '@/Components/Core/Flex.svelte'
	import Inline from '@/Components/Core/Inline.svelte'
	import Stack  from '@/Components/Core/Stack.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'
	import Thumbnail   from '@/Components/UI/Thumbnail.svelte'

	import clsx from 'clsx'

	let {
		active,
		entity,
		layout = "inline",
		onclick = () => {},
		size = "sm"
	} = $props()

	let cx = $derived({
		card:	clsx('cursor-pointer'),

		thumbnail: {
			base: clsx('aspect-square rounded', {
				'bg-accent-softer':    active,
				'bg-neutral-softest': !active
			}),
			xs:	  clsx('w-8'),
			sm:	  clsx('w-12'),
			md:	  clsx('w-24'),
			lg:	  clsx('w-32'),
			xl:	  clsx('w-40'),
			auto: clsx('w-full')
		},

		text: {
			base: clsx('px-1', {
				'text-accent': active
			}),
			xs:	  clsx("px-1 -space-y-1"),
			sm:	  clsx("px-1 -space-y-0.5"),
			md:	  clsx("px-1 -space-y-1"),
			lg:	  clsx("px-1 -space-y-0.5"),
			xl:	  clsx("px-1 -space-y-1"),
			auto: clsx('px-1 -space-y-1')
		},
		
		line: {
			primary: 	clsx('text-sm text-left line-clamp-1 break-all'),
			secondary: 	clsx('text-xs text-left line-clamp-1 break-all opacity-50')
		}
	})

</script>



{#snippet content()}
	<Thumbnail class="{cx.thumbnail.base} {cx.thumbnail[size]}" src={entity.image} />
	<Stack class="{cx.text.base} {cx.text[size]}">
		<p class={cx.line.primary}>{entity.name}</p>
		<p class={cx.line.secondary}>{entity.type || entity.alias}</p>
	</Stack>
{/snippet}



{#if layout === "inline"}
	<Inline class={cx.card} gap={0.5} onclick={onclick}>
		{@render content()}
	</Inline>
{:else if layout === "stack"}
	<Stack class={cx.card} gap={0.5} onclick={onclick}>
		{@render content()}
	</Stack>
{/if}