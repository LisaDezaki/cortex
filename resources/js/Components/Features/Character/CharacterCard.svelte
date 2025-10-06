<script>
	import Card  from '@/Components/UI/Card.svelte'

    let {
		class: className,
		character,
		options,
		title,
		subtitle,
        ...restProps
    } = $props()
</script>

<Card class={className}
	aspect="square" icon="UserCircle" iconWeight="fill"
	image={character.image?.url}
	title={title || character.name}
	subtitle={subtitle || character.alias}
	href={character.routes?.show}
	options={options}
	starred={character.starred}
	onStar={() => character.star()}
	disabledIcon="Handshake"
{...restProps} />