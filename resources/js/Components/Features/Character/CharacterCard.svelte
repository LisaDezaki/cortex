<script>
	import { route } from 'momentum-trail'

	import Card  from '@/Components/UI/Card.svelte'

    let {
		class: className,
		character,
		href = route('characters.show', {character: character.slug}),
		onclick,
		options,
        ...restProps
    } = $props()
</script>

<Card
	aspect="square"
	icon="User"
	image={character.portrait?.url}
	title={character.name}
	subtitle={character.alias}
	href={href}
	options={options}
{...restProps} />