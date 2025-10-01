<script>
	import Card  from '@/Components/UI/Card.svelte'

    let {
		class: className,
		location,
		options,
        ...restProps
    } = $props()
</script>

<Card class={className} subtitleClass={location.isWorldMap ? 'text-accent' : ''}
	aspect="video" icon="MapPinArea" iconWeight="fill"
	image={location.image?.url}
	title={location.name}
	subtitle={location.type}
	href={location.routes.show}
	options={options}
	starred={location.starred}
	onStar={() => location.star()}
{...restProps} />