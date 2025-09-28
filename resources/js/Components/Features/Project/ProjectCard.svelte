<script>
	import Card from '@/Components/UI/Card.svelte';

    let {
		class: className,
		href,
		image,
		icon,
		options,
		project,
		title,
		subtitle,
        ...restProps
    } = $props()
</script>

<Card
	aspect="video"
	icon="GlobeStand"
	image={project?.image?.url}
	title={project?.name}
	subtitle={project?.type}
	href={href}
	options={options}
{...restProps} />