<script lang="ts">
	import Button from '$lib/Button.svelte'
</script>

<svelte:head>
	<title>Home | ChatService</title>
	<meta name="description" content="." />
</svelte:head>

<section id="hero">
	<div class="row">
		<div>
			<h1 id="headline">Wondering what platform your friends moved to?</h1>
			<h2 id="headlineSupport">
				Find out for yourself why everyone is on our platform to connect with their friends.
			</h2>
			<Button text="Start connecting" on:click={() => (window.location.href = 'threads')} />
		</div>
		<!-- <div id="phone_container" style="max-height: 200px;">
			<img id="hero_img" src="phone_example.png" alt="phone sample">
			<img id="hero_img_2" src="phone_example.png" alt="phone sample">
		</div> -->
	</div>
</section>

<style>
	section#hero {
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: flex-start;
		padding: 2em;
		min-height: 400px;
		background: url('/images/hero.svg') #f1f6f9;
		background-repeat: no-repeat;
		background-position: right bottom;
		overflow: hidden;
	}
	#headline {
		width: 90%;
		max-width: 750px;
		margin: 0 0 0.5em;
		color: var(--defaultText);
		font-size: 2.325em;
		line-height: 1.35;
	}
	#headlineSupport {
		width: 75%;
		max-width: 500px;
		margin: 0 0 1em;
		color: var(--secondaryText);
		font-size: 1.65em;
		font-weight: 400;
		line-height: 1.3;
	}
	/* #hero_img, #hero_img_2{
		/* height: 500px; */
	/* transform: rotate(22.5deg) translate(200px, -75px); *
		margin-left: 2.5rem;
		width: 218px;
	}
	#hero_img_2{
		width: 242px;
	} */
	@media only screen and (max-width: 960px) {
		section#hero {
			background-position: -25% 150%;
		}
		section#hero .row {
			flex-direction: column;
		}
		/* section#hero .row #phone_container{
		display: none;
	} */
		#headline,
		#headlineSupport {
			width: 100%;
		}
	}
</style>
