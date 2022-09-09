<script lang="ts">
	import { readableTime, colorHash } from '$lib/utils'
	import { userState } from '../../userState'

	let data: Thread[] | Promise<Thread[]> = []
	const loadThreads = () =>
		(data = fetch(`/api/${$userState.user.id}/messages`).then((res) => res.json()))

	$: loadThreads()
</script>

<svelte:head>
	<title>Threads | ChatService</title>
	<meta name="description" content="See all the threads you have between your friends." />
</svelte:head>

<div class="container" on:contextmenu|preventDefault={() => loadThreads()}>
	{#await data}
		<div class="trueCenter">Loading...</div>
	{:then threads}
		{#each threads as thread}
			<a
				href={'chat/' + thread.otherUser.id}
				class="thread row"
				class:unread={!thread.metadata}
				on:click|once={() => ($userState.otherUser = thread.otherUser)}
			>
				<div class="imgContainer">
					<!-- {#if}<img src="" alt="" on:error={() => this.style.display = 'none'}>{/if} -->
					<div class={colorHash(thread.otherUser.first[0] ?? '_')}>{thread.otherUser.first[0]}</div>
				</div>
				<div class="info row">
					<div class="threadDetails">
						<div class="receiver">
							{thread.otherUser.first + ' ' + thread.otherUser.last}
						</div>
						<div class="content">
							{#if thread.msgType === 'text/plain'}
								{thread.youSent ? 'You: ' : ''}{thread.content}
							{:else}
								{thread.youSent ? 'You: ' : ''}sent a {thread.msgType}
							{/if}
						</div>
					</div>
					<div class="metaData">
						<div class="timestamp">{readableTime(thread.posted)}</div>
						<div class="unreadCount" />
					</div>
				</div>
			</a>
		{:else}
			<div class="trueCenter">No threads, start chatting</div>
		{/each}
	{:catch err}
		<div class="trueCenter">An error occured <br /> {err}</div>
	{/await}
</div>

<style>
	.container {
		display: flex;
		flex-direction: column;
		height: 100%;
		flex-grow: 1;
		justify-content: flex-start;
		padding-top: 0.33rem;
	}
	.thread {
		position: relative;
		padding: 16px calc(var(--edgePadding) / 2);
		padding: 0.5rem 1rem;
		color: var(--defaultText);
		border-bottom: 1px solid var(--hover);
		overflow: hidden;
		user-select: none;
		text-decoration: none;
		transition: all ease-in-out 75ms;
	}
	.thread:hover {
		background: var(--hover);
		background: #f7f8fb;
	}
	.imgContainer {
		position: relative;
		height: 40px;
		min-width: 40px;

		border-radius: 50%;
		background-color: #ddd;
		color: #fff;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
		overflow: hidden;
	}
	.thread .imgContainer .avatarColor_0 {
		background-color: #ee675c;
		background-color: #007aff;
	}
	.thread .imgContainer .avatarColor_1 {
		background-color: #fcc934;
		background-color: #ffcc00;
	}
	.thread .imgContainer .avatarColor_2 {
		background-color: #1a73e8;
		background-color: #32ade6;
	}
	.thread .imgContainer .avatarColor_3 {
		background-color: #af5cf7;
		background-color: #00c7be;
	}
	.thread .imgContainer .avatarColor_4 {
		background-color: #4ecde6;
		background-color: #30b0c7;
	}
	.thread .imgContainer .avatarColor_5 {
		background-color: #5bb974;
		background-color: #34c759;
	}
	.thread .imgContainer .avatarColor_6 {
		background-color: #fa903e;
		background-color: #ff9500;
	}
	.thread .imgContainer .avatarColor_7 {
		background-color: #ff63b8;
		background-color: #ff2d55;
	}
	.thread .imgContainer .avatarColor_8 {
		background-color: #af5cf7;
		background-color: #af52de;
	}
	.thread .imgContainer .avatarColor_9 {
		background-color: #1967d2;
		background-color: #5856d6;
	}
	.thread .imgContainer .avatarColor_10 {
		background-color: #b52480;
		background-color: #a2845e;
	}
	.thread .imgContainer .spam {
		background-color: #d93025;
		background-color: #ff3037;
		color: #f1f3f4;
		fill: #f1f3f4;
	}
	.thread .imgContainer .blocked {
		color: #5f6368;
		fill: #5f6368;
	}
	/*  .ios-color-dark-blue { background-color: rgb(10,132,255);}
	.ios-color-dark-brown { background-color: rgb(172,142,104);}
	.ios-color-dark-cyan { background-color: rgb(100,210,255);}
	.ios-color-dark-gray { background-color: rgb(142,142,147);}
	.ios-color-dark-gray2 { background-color: rgb(99,99,102);}
	.ios-color-dark-gray3 { background-color: rgb(72,72,74);}
	.ios-color-dark-gray4 { background-color: rgb(58,58,60);}
	.ios-color-dark-gray5 { background-color: rgb(44,44,46);}
	.ios-color-dark-gray6 { background-color: rgb(28,28,30);}
	.ios-color-dark-green { background-color: rgb(48,209,88);}
	.ios-color-dark-indigo { background-color: rgb(94,92,230);}
	.ios-color-dark-mint { background-color: rgb(102,212,207);}
	.ios-color-dark-orange { background-color: rgb(255,159,10);}
	.ios-color-dark-pink { background-color: rgb(255,55,95);}
	.ios-color-dark-purple { background-color: rgb(191,90,242);}
	.ios-color-dark-red { background-color: rgb(255,69,58);}
	.ios-color-dark-teal { background-color: rgb(64,200,224);}
	.ios-color-dark-yellow { background-color: rgb(255,214,10);} */
	/* .imgContainer img{
		display: block;
		height: 100%;
		width: 100%;
		background: white;
	}
	.imgContainer img[src='./images/anonymous.png']{
		background: unset;
	} */
	.imgContainer > div {
		display: block;
		height: 100%;
		width: 100%;
		font-size: 20px;
		line-height: 40px;
		text-align: center;
		text-transform: uppercase;
	}
	.info {
		box-sizing: border-box;
		width: 100%;
		justify-content: space-between;
		padding-left: calc(var(--edgePadding) / 2);
		padding-left: 1rem;
		overflow: hidden;
		transition: all cubic-bezier(0.6, 0, 0.2, 1) 100ms;
	}
	.threadDetails {
		width: 73%;
	}
	.thread.unread:not(:focus):not(:active) .info {
		font-weight: 700;
	}
	.receiver {
		padding: 2px 0;
	}
	.content {
		font-size: 0.875rem;
		padding: 3px 0;
		color: var(--secondaryText);
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
	}
	.metaData {
		width: 75px;
		min-width: 75px;
		text-align: end;
	}
	.timestamp {
		padding: 2px 0;
		font-size: 0.75rem;
		color: #959da5;
		transition: all cubic-bezier(0.6, 0, 0.2, 1) 125ms;
	}
	/* .thread.unread:not(:focus):not(:active) .timestamp {
		color: #02d25d;
	} */
	.unreadCount {
		opacity: 0;
		float: right;
		/* min-width: 12px; */
		height: 18px;
		margin: 6px 0 0;
		padding: 2px 5px;
		border-radius: 11px;
		font-weight: 700;
		font-size: 0.775rem;
		line-height: 1.1rem;
		text-align: center;
		color: var(--hover);
		/* background-color: #02d25d; */
		background-color: #34d058;
		user-select: none;
		transition: all cubic-bezier(0.6, 0, 0.2, 1) 150ms;

		height: 3px;
		width: 3px;
		margin: 12px 0 4px;
		padding: 2px 2px;
	}
	.thread.unread:not(:focus):not(:active) .unreadCount {
		opacity: 1;
		color: #fff;
	}
</style>
