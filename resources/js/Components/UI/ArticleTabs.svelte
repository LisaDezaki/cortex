<script>

	import clsx from 'clsx'
	import { Tabs } from '@/Components/Core'
	import Icon from '@/Components/UI/Icon.svelte'

	let {
		children,
		class: className,
		tabs,
		...restProps
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		tabs: 	 clsx('flex items-start justify-center gap-12 w-full', className),
		list:	 clsx('pt-12 w-56'),
		trigger: clsx('flex items-center justify-start gap-2 px-3 py-1.5 rounded w-full hover:bg-neutral-softest'),
		active:	 clsx('text-accent')
	})

</script>



<Tabs class={cx.tabs} orientation="vertical" {...restProps}>

	<Tabs.List class={cx.list}>
		{#each tabs as tab}
			<Tabs.Trigger class={cx.trigger} value={tab.value}>
				{#if tab.icon}
					<Icon name={tab.icon} size="md" />
				{/if}
				<span class:text-accent={tab.active}>{tab.label}</span>
			</Tabs.Trigger>
		{/each}
	</Tabs.List>

	<div class="w-full">
		{@render children?.()}
	</div>

</Tabs>