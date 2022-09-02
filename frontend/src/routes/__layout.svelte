<script lang="ts">
	import { webVitals } from '$lib/vitals'
	import { browser } from '$app/env'
	import { page } from '$app/stores'
	import Header from '$lib/Header.svelte'
	import '../app.css'

	const analyticsId = import.meta.env.VERCEL_ANALYTICS_ID

	$: if (browser && analyticsId) {
		webVitals({
			path: $page.url.pathname,
			params: $page.params,
			analyticsId
		})
	}
</script>

<Header path={$page.url.pathname} />
<main>
	<slot />
</main>

<style>
	main {
		display: flex;
		flex-direction: column;
		height: 100%;
		flex-grow: 1;
		padding-top: 1px;
	}
</style>
