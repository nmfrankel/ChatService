<script lang="ts">
	import { page } from '$app/stores'
	import Header from '$lib/header.svelte'
	import '../app.css'
</script>

<Header path={$page.url.pathname} />
<main style="padding-top: 1px;">
	<slot />
</main>