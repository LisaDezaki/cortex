<script>
	import Card  from '@/Components/UI/Card.svelte'

    let {
		class: className,
		faction,
		options,
        ...restProps
    } = $props()
</script>

<Card class={className}
	aspect="square"
	image={faction.image?.url}
	thumbnailIcon="FlagBannerFold"
	title={faction.name}
	subtitle="{faction.members?.items.length} member{faction.members?.items.length === 1 ? '' : 's'}"
	href={faction.routes.show}
	options={options}
	starred={faction.starred}
	onStar={() => faction.star()}
{...restProps} />