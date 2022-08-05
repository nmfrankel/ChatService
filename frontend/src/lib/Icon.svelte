<script lang="ts">
	export let name: string,
		width: string = '24px',
		height: string = '24px',
		margin: string = '0px'
</script>

<svg {width} {height} style="margin-right: {margin}">
	<use href={`icons.svg#${name}`} />
</svg>
