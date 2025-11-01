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
	title={title || faction.name}
	subtitle={subtitle || faction.type}
	options={options}
	starred={faction.starred}
	onStar={() => faction.star()}
{...restProps} />