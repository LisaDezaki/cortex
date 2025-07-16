<script>

	import Button from '@/Components/Button.svelte'
	import Icon from '@/Components/Icon.svelte'

	let {
		children,
		class: className,
		href,
		...attrs
	} = $props()

</script>

<Button class="absolute top-6 left-6 text-slate-400 hover:bg-slate-500/10 rounded-full h-12 w-12 hover:text-emerald-500 {className}" {href}>
	<Icon name="ArrowLeft" size={32} weight="light" />
</Button>

<style lang="postcss">



</style>