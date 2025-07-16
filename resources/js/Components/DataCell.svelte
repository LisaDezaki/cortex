<script>
	import { Link } from '@inertiajs/svelte'

	import Icon from '@/Components/Icon.svelte'
	import Thumbnail from '@/Components/Thumbnail.svelte'

    let {
		class: className,
		href,
		image,
		icon,
		title,
		subtitle,
        ...attrs
    } = $props()
</script>

<Link href={href} class="flex items-center gap-2 hover:text-emerald-500 hover:underline {className}">
	{#if image}
		<Thumbnail class="h-9 w-9" icon={icon} src={image} alt={title} />
	{:else if icon}
		<div class="bg-slate-200 flex items-center justify-center h-9 w-9 rounded-lg flex-shrink-0">
			<Icon name={icon} size={20} />
		</div>
	{/if}
	<div>
		{#if title}
			<div class="leading-5 whitespace-nowrap">{title}</div>
		{/if}
		{#if subtitle}
			<div class="font-style-tiny opacity-60">{subtitle}</div>
		{/if}
	</div>
</Link>