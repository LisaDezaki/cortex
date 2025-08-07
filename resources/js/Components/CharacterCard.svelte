<script>
	import Card from '@/Components/Card.svelte'
	import { route } from 'momentum-trail'

    let {
		class: className,
		character,
		href,
		onclick,
		showControls = false,
        ...restProps
    } = $props()

	function deleteCharacter() {

	}

	function handleClick(e) {
		if (onclick) {
			e.preventDefault()
			onclick(e, character)
		}
	}
</script>

<Card
	icon="User"
	image={character.portrait?.url}
	title={character.name}
	subtitle={character.subtitle}
	onclick={handleClick || null}
	href={onclick ? null : route('characters.show', {character: character.slug})}
	options={showControls ? [
		{  label: "Set Faction",  icon: "FlagBannerFold" },
		{  label: "Set Location", icon: "MapPin" },
		{  label: "Rename",       icon: "Pen" },
		{  label: "Edit",         icon: "Pen",   href: route('characters.edit', {character: character.slug}) },
		{  label: "Delete",       icon: "Trash", onclick: deleteCharacter, theme: "danger" }
	] : null}
	{...restProps}
/>