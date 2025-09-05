<script>
	import Card from '@/Components/UI/Card.svelte';

    let {
		class: className,
		href,
		image,
		icon,
		options,
		title,
		subtitle,
        ...restProps
    } = $props()
</script>

<Card aspect="video"
	icon="GlobeStand"
	image={image}
	title={title}
	subtitle={subtitle}
	href={href}
	options={options}
{...restProps} />