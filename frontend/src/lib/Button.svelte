<script lang="ts">
	import { createEventDispatcher } from 'svelte'
	import Icon from '$lib/Icon.svelte'

	const dispatch: any = createEventDispatcher()
	const transferClick = () => dispatch('click')

	export let classes: string = 'default',
		style: string = '',
		icon: string = '',
		text: string = ''
</script>

{#if text || icon}
	<button class={classes} {style} on:click={transferClick}>
		{#if icon !== '' && text}
			<Icon name={icon} height="1.15em" width="1.15em" margin="1em" />
		{:else if icon !== ''}
			<Icon name={icon} height="1.15em" width="1.15em" />
		{/if}
		<span class:leadingIcon={icon !== ''}>{text}</span>
	</button>
{/if}

<style>
	button {
		position: relative;
		display: inline-flex;
		align-items: center;
		padding: 0 0.75rem;
		border: none;
		border-radius: var(--borderRadius);
		border-radius: 4px;
		text-align: center;
		font-size: 1rem;
		height: 2em;
		white-space: nowrap;
		cursor: pointer;
		-webkit-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}
	button:hover {
		transition: background-color 0.12s ease-out, color 0.12s ease-out;
	}
	button.small {
		font-size: 0.875rem;
		padding: 0 0.5rem;
	}
	/* button.bold{
		font-weight: 700;
	} */

	button.default {
		background-color: #0969da;
		color: #fff;
		fill: #fff;
		/* box-shadow:
			0px 2px 1px -1px rgba(0, 0, 0, 0.2),
			0px 1px 1px 0px rgba(0, 0, 0, 0.14),
			0px 1px 3px 0px rgba(0, 0, 0, 0.12); */
	}
	button.default:hover {
		background-color: #1065c5;
		color: var(--offWhite);
	}
	button.default:active {
		background-color: #0a52a4;
		color: #fff;
	}

	button.muted {
		/* background-color: var(--offWhite); */
		background-color: rgba(208, 215, 222, 0.32);
		color: var(--offBlack);
		fill: var(--offBlack);
	}
	button.muted:hover {
		/* background-color: #d9d9e3; */
		background-color: rgba(180, 186, 192, 0.32);
	}
	button.muted:active {
		/* background-color: #c5c5d2; */
		background-color: rgba(159, 164, 170, 0.32);
	}

	button.minimal {
		/* border: 1px solid rgba(208,215,222,0.32); */
		border: none;
		background-color: transparent;
		color: var(--fadedOffBlack);
		fill: var(--fadedOffBlack);
	}
	button.minimal:hover {
		color: rgb(36, 41, 47);
		fill: rgb(36, 41, 47);
		background-color: rgba(208, 215, 222, 0.32);
	}
	button.minimal:active {
		background-color: rgba(180, 186, 192, 0.32);
	}

	/* button{
		display: inline-flex;
		align-items: center;
		padding: .4rem 1rem;
		/* background-color: -internal-light-dark(#efefef, #3b3b3b); *
		background-color: var(--offBlack);
		color: var(--offWhite);
		border-radius: var(--borderRadius);
		border: 2px solid var(--offBlack);
		text-decoration: none;
		font-size: .875rem;
		font-weight: 700;
		cursor: pointer;
		box-shadow:
			0px 2px 1px -1px rgba(0, 0, 0, 0.2),
			0px 1px 1px 0px rgba(0, 0, 0, 0.14),
			0px 1px 3px 0px rgba(0, 0, 0, 0.12);
		transition: all 300ms cubic-bezier(0.075, 0.82, 0.165, 1);
		content: '';
	}
	button.secondary{
		background-color: var(--offWhite);
		color: var(--offBlack);
	}
	button.minimal{
		color: var(--offBlack);
		background-color: var(--offWhite);
		border-color: var(--offWhite);
	}
	button:hover, button.secondary:hover, button:active, button.secondary:active{
		color: var(--fadedOffBlack);
		border-color: var(--fadedOffBlack);
		background-color: var(--fadedOffWhite);
		box-shadow:
			0px 3px 3px -2px rgba(0, 0, 0, 0.2),
			0px 3px 4px 0px rgba(0, 0, 0, 0.14),
			0px 1px 8px 0px rgba(0, 0, 0, 0.12);
	}
	button:active{
		color: var(--fadedOffWhite);
	}
	button:focus, button.secondary:focus {
		outline: none;
	}
	button:disabled, button.secondary:disabled {
		color: #999;
	}
	button:not(:disabled):active{
		background-color: var(--offBlack);
	}
	button.secondary:not(:disabled):active{
		background-color: var(--offWhite);
	} */

	/* openAI */
	/* :root{
		--primary: #10a37f;
		--primary-50: #ebfaeb;
		--primary-100: #d2f4d3;
		--primary-200: #b9eebc;
		--primary-300: #93e69c;
		--primary-400: #68de7a;
		--primary-500: #19c37d;
		--primary-600: #10a37f;
		--primary-700: #1a7f64;
		--primary-800: #1b5d4a;
		--primary-900: #183d31;
		--primary-50a: rgba(16,163,127,.2);
		--primary-100a: rgba(16,163,127,.3);
		--secondary: #5436da;
		--secondary-50: #ecebf9;
		--secondary-100: #d2cff2;
		--secondary-200: #b9b4ec;
		--secondary-300: #a198e6;
		--secondary-400: #897ce2;
		--secondary-500: #715fde;
		--secondary-600: #5436da;
		--secondary-700: #482da8;
		--secondary-800: #3b2479;
		--secondary-900: #281852;
		--secondary-100a: rgba(84,54,218,.3);
		--green-50: #ebfaeb;
		--green-100: #d2f4d3;
		--green-200: #b9eebc;
		--green-300: #93e69c;
		--green-400: #68de7a;
		--green-500: #19c37d;
		--green-600: #10a37f;
		--green-700: #1a7f64;
		--green-800: #1b5d4a;
		--green-900: #183d31;
		--green-100a: rgba(16,163,127,.3);
		--red-50: #fdebeb;
		--red-100: #f9cfcf;
		--red-200: #f6b2b3;
		--red-300: #f49394;
		--red-400: #f17173;
		--red-500: #ef4146;
		--red-600: #c23539;
		--red-700: #9d2b2e;
		--red-800: #7b2124;
		--red-900: #59181a;
		--red-100a: rgba(239,65,70,.3);
		--gray-50: #f7f7f8;
		--gray-100: #ececf1;
		--gray-200: #d9d9e3;
		--gray-300: #c5c5d2;
		--gray-400: #acacbe;
		--gray-500: #8e8ea0;
		--gray-600: #6e6e80;
		--gray-700: #565869;
		--gray-800: #353740;
		--gray-900: #202123;
		--medium-wash: #eff7f8;
		--bg-color: #fff;
		--text-primary: #202123;
		--text-default: #353740;
		--text-secondary: #6e6e80;
		--text-disabled: #acacbe;
		--text-error: #ef4146;
		--font-size-small: 16px;
		--input-border: var(--gray-300);
		--input-border-focus: var(--primary-600);
		--input-focus-ring: 0px 0px 0px 1px #10a37f;
		--icon-warning-color: #f4ac36;
		--heading-margin-top: 30px;
		--heading-margin-bottom: 16px;
		--content-width: 760px;
		--content-v-padding: 40px;
		--content-h-padding: 56px;
		--border-radius: 4px;
		--sans-serif: "ColfaxAI",helvetica,sans-serif;
		--monospace: "Roboto Mono",sfmono-regular,consolas,liberation mono,menlo,courier,monospace;
	}
	.btn-primary.btn-filled {
		background-color: #10a37f;
	}
	.btn-neutral.btn-filled:active {
		background-color: #c5c5d2;
	}
	.btn-neutral.btn-filled:hover {
		background-color: #d9d9e3;
	}
	.btn:not(.btn-full)+.btn {
		margin-left: 8px;
	}
	.btn-neutral.btn-filled {
		background-color: #ececf1;
		color: #353740;
	}
	.btn-filled, .btn-filled:visited {
		color: #fff;
	}
	.btn-sm {
		font-size: 14px;
		line-height: 20px;
		padding: 6px 12px;
	}
	.btn, .btn:hover {
		text-decoration: none;
	}
	.btn {
		border: none;
		border-radius: 3px;
		box-sizing: border-box;
		cursor: pointer;
		display: inline-flex;
		font-weight: 400;
		justify-content: center;
		line-height: 1.4;
		position: relative;
		transition: box-shadow .3s,background-color .3s,color .3s;
		-webkit-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}
	button, textarea {
		font-family: ColfaxAI,helvetica,sans-serif;
		font-family: var(--sans-serif);
	} */
</style>
