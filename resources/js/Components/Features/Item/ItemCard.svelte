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
	aspect="square" thumbnailIcon="UserCircle"
	image={character.image?.url}
	title={title || character.name}
	subtitle={subtitle || character.alias}
	options={options}
	starred={character.starred}
	onStar={() => character.star()}
	disabledIcon="Handshake"
{...restProps} />