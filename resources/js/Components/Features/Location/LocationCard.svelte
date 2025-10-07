<script>
	import Card  from '@/Components/UI/Card.svelte'

    let {
		class: className,
		location,
		options,
        ...restProps
    } = $props()
</script>

<Card
	class={className}
	subtitleClass={location.isWorldMap ? 'text-accent' : ''}
	aspect="video"
	image={location.image?.url}
	icon={location.icon || "MapPin"} iconWeight="fill"
	thumbnailIcon="MapPinArea"
	title={location.name}
	subtitle={location.type}
	href={location.routes.show}
	options={options}
	starred={location.starred}
	onStar={() => location.star()}
{...restProps} />