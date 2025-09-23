<script>
	import { route } from 'momentum-trail'

	import Card  from '@/Components/UI/Card.svelte'
	import Icon  from '@/Components/UI/Icon.svelte'

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
	disabledIcon="Handshake"
	image={character.image?.url}
	title={character.name}
	subtitle={character.alias}
	href={onclick ? undefined : href}
	options={options}
	onclick={onclick}
{...restProps} />