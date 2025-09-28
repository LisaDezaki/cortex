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

	let media_emblem = $derived(faction.media.filter(m => m.type === 'emblem')?.[0])

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
	image={faction.image?.url}
	title={faction.name}
	subtitle="{faction.members.length} member{faction.members.length === 1 ? '' : 's'}"
	onclick={handleClick || null}
	href={onclick ? null : route('factions.show', {faction: faction.slug})}
	options={options}
{...restProps} />