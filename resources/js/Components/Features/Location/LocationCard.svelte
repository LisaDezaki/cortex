<script>
	import { route } from 'momentum-trail'

	import Card  from '@/Components/UI/Card.svelte'

    let {
		class: className,
		href,
		location,
		onclick,
		options,
        ...restProps
    } = $props()

	const handleClick = (e) => {
		if (onclick) {
			e.preventDefault()
			onclick(e, location)
		}
	}
</script>

<Card
	aspect="video"
	icon="MapPinArea"
	image={location.image?.url}
	title={location.name}
	subtitle={location.parent?.name}
	subtitleClass={location.isWorldMap ? 'text-accent' : ''}
	onclick={handleClick || null}
	href={onclick ? null : route('locations.show', {location: location.slug})}
	options={options}
{...restProps} />