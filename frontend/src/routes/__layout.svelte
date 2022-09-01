<script lang="ts">
	import { webVitals } from '$lib/vitals'
	import { browser } from '$app/env'
	import { page } from '$app/stores'
	import Header from '$lib/Header.svelte'
	import '../app.css'

	$: if (browser && analyticsId) {
		webVitals({
			path: $page.url.pathname,
			params: $page.params,
			analyticsId
		})
	}
</script>

<Header path={$page.url.pathname} />
<main style="padding-top: 1px;">
	<slot />
</main>
