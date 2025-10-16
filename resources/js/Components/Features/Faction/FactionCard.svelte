<script>
	import Card  from '@/Components/UI/Card.svelte'

    let {
		class: className,
		faction,
		options,
		title,
		subtitle,
        ...restProps
    } = $props()
</script>

<Card class={className}
	aspect="square" thumbnailIcon="FlagBannerFold"
	image={faction.image?.url}
	title={faction.name}
	subtitle="{faction.members?.items.length} member{faction.members?.items.length === 1 ? '' : 's'}"
	options={options}
	starred={faction.starred}
	onStar={() => faction.star()}
{...restProps} />