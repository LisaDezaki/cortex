<script>
	import Card  from '@/Components/UI/Card.svelte'

    let {
		class: className,
		location,
		options,
		title,
		subtitle,
        ...restProps
    } = $props()
</script>

<Card class={className}
	subtitleClass={location.isWorldMap ? 'text-accent' : ''}
	aspect="video" thumbnailIcon="MapPinArea"
	image={location.image?.url}
	icon={location.icon || "MapPin"}
	title={title || location.name}
	subtitle={subtitle || location.type}
	options={options}
	starred={location.starred}
	onStar={() => location.star()}
{...restProps} />