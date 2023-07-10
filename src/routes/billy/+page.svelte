<svelte:head>
	<!-- <meta http-equiv="refresh" content="5; url=https://"> -->
</svelte:head>

<div />

<style>
	:global(html, body) {
		max-height: 100vh;
		max-width: 100vw;
		overflow: hidden;
	}
	:global(header) {
		display: none;
	}
	div {
		position: relative;
		top: -1px;
		height: 100vh;
		width: 100vw;
		content: '';
		background: url('/billy.jpg') no-repeat 60% center;
		background-size: cover;
		z-index: 10;
	}
</style>