<script>
	import Card  from '@/Components/UI/Card.svelte'

    let {
		class: className,
		location,
		options,
        ...restProps
    } = $props()
</script>

<Card class={className}
	subtitleClass={location.isWorldMap ? 'text-accent' : ''}
	aspect="video" thumbnailIcon="MapPinArea"
	image={location.image?.url}
	icon={location.icon || "MapPin"}
	title={location.name}
	subtitle={location.type}
	options={options}
	starred={location.starred}
	onStar={() => location.star()}
{...restProps} />