<script>
	import { route } from 'momentum-trail'

	import Card  from '@/Components/UI/Card.svelte'

    let {
		class: className,
		faction,
		href,
		onclick,
		options,
        ...restProps
    } = $props()

	const handleClick = (e) => {
		if (onclick) {
			e.preventDefault()
			onclick(e, faction)
		}
	}
</script>

<Card
	aspect="square"
	icon="User"
	image={faction.portrait?.url}
	title={faction.name}
	subtitle={faction.alias}
	onclick={handleClick || null}
	href={onclick ? null : route('factions.show', {faction: faction.slug})}
	options={options}
{...restProps} />