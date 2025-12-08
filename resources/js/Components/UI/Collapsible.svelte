<script>

	import clsx from 'clsx'
	import Stack from '@/Components/Core/Stack.svelte'
	import Button from '@/Components/UI/Button.svelte'

	let {
		children,
		class: className,
		collapsed = $bindable(true),
		collapsedClass = 'line-clamp-3 overflow-hidden',
		...restProps
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		p: clsx({
			'whitespace-pre-wrap': true,
			[collapsedClass]: collapsed
		}, className),
		button: clsx({
			'inline text-accent': true
		})
	})

</script>



{#if children}
	<Stack class={className}>
		<p class={cx.p}>
			{@render children()}
			<button class={cx.button} onclick={() => collapsed = !collapsed}>
				{#if collapsed}Read more&hellip;{:else}Read less&hellip;{/if}
			</button>
		</p>
	</Stack>
{/if}