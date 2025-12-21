<script>
	import Flex from '@/Components/Core/Flex.svelte'
	import clsx from 'clsx'

	let {
		children,
		class: className,
		code
	} = $props()

	let cx = {
		code: clsx('bg-accent-softest relative px-3 py-2 rounded text-accent text-sm w-full', className)
	}
</script>

<pre class={cx.code}>{code}</pre>